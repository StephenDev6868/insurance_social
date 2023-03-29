<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Notify;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\File;
use App\Services\Upload\UploadService;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $data = $request->all();
        // if ($provider == 'google') {
        //     return $this->checkGoogle($request->social_token);
        // }

        // if ($provider == 'facebook') {
        //     return $this->checkFacebook($request->social_token);
        // }
        $validator = Validator::make($data, [
            'email' => 'email',
        ]);
        if ($validator->fails()) {
            return response()->json(['statusCode' => 422, 'message' => $validator->errors()->first()]);
        } else if (!isset($data['email']) || !isset($data['password'])) {
            return response()->json(['statusCode' => 404, 'message' => 'Please fill all fields']);
        } else {
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::find(Auth::user()->id);
                if ($user['check'] == 0) {
                    return response()->json(['statusCode' => 400, 'message' => 'Tài khoản chưa được admin duyệt']);
                } else {
                    $token =  $user->createToken('MyApp')->accessToken;
                    $user->update(['token' => $token]);
                    return response()->json(['statusCode' => 200, 'data' => ['user' => $user, 'count_infor' => count(Notify::all()), 'count_cart' => 0]]);
                }
            } else {
                return response()->json(['statusCode' => 401, 'message' => 'Unauthorised']);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();
        return response()->json(['statusCode' => 200, 'message' => 'Đăng xuất thành công']);
    }
    public function register(Request $request)
    {
        $data = $request->all();
        if (User::where('email', $data['email'] ?? '')->where('check', 1)->count() > 0) {
            $validator = Validator::make($data, [
                'email' => 'email|unique:users,email',
                //'mobile'=>'numeric|regex:/(01)[0-9]{9}/|unique:users,mobile'
                'mobile'=>'numeric|unique:users,mobile'
            ]);
        } else {
            $validator = Validator::make($data, [
                'email' => 'email',
                'mobile'=>'numeric|unique:users,mobile'
                //'mobile'=>'numeric|regex:/(01)[0-9]{9}/'
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['statusCode' => 422, 'message' => $validator->errors()->first()]);
        } else if (!isset($data['email']) || !isset($data['password']) || !isset($data['confirm_password']) || !isset($data['name']) || !isset($data['type'])) {
            return response()->json(['statusCode' => 404, 'message' => 'Please fill all fields']);
        } else {
            if ($data['password'] != $data['confirm_password'] || count_chars($data['password']) !== count_chars($data['confirm_password'])) {
                return response()->json(['statusCode' => 401, 'message' => 'Password does not match']);
            } else {
                $data['password'] = Hash::make($data['password']);
                $data['image']=url('imgs/user.png');
                if (User::where('email', $data['email'])->count() > 0) {
                    $user = User::where('email', $data['email'])->first();
                    $user->update($data);
                } else {
                    if ($data['type'] != 1) {
                        $data['check'] = 0;
                        if ($request->hasFile('front_image') && $request->hasFile('back_image')) {
                            $front_image = $request->file('front_image');
                            $back_image= $request->file('back_image');
                            $front_reimage = UploadService::upload('user', $front_image);
                            $back_reimage = UploadService::upload('user', $back_image);
                            $data['front_image'] = $front_reimage;
                            $data['back_image'] = $back_reimage;
                        } else {
                            return response()->json(['statusCode' => 422, 'message' => 'Vui lòng tải ảnh cccd/cmnd của bạn để admin phê duyệt']);
                        }
                        if ($data['type'] == 3 && !$request->hasFile('certificate_file')) {
                            return response()->json(['statusCode' => 422, 'message' => 'Vui lòng tải file chứng chỉ của bạn để admin phê duyệt']);
                        }
                    }
                    $user = User::create($data);
                }
                $otp = rand(100000, 999999);
                $mailData = [
                    "name" => $user['name'],
                    "otp" => $otp
                ];
                $user->update(['otp' => $otp]);
                $result =  Mail::to($data['email'])->send(new \App\Mail\SendMail($mailData));
                return response()->json(['statusCode' => 200, 'message' => 'Send OTP Successfully']);
            }
        }
    }
    public function sendEmail(Request $request)
    {
        $data = $request->all();
        if (User::where('email', $data['email'])->count() > 0) {
            $user = User::where('email', $data['email'])->first();
            $otp = rand(100000, 999999);
            $user->update(['otp' => $otp]);
            $mailData = [
                "name" => $user['name'],
                "otp" => $otp
            ];
            Mail::to($data['email'])->send(new \App\Mail\SendMail($mailData));
            return response()->json(['statusCode' => 200, 'data' => ['otp' => $otp]]);
        } else {
            return response()->json(['statusCode' => 401, 'message' => 'Email not exists']);
        }
    }
    public function checkOtp(Request $request)
    {
        $data = $request->all();
        if (User::where('email', $data['email'])->where('otp', $data['otp'])->count() > 0) {
            $user = User::where('email', $data['email'])->first();
            $user->update(['otp' => '', 'check' => 1, 'token' => $user->createToken('MyApp')->accessToken]);
            return response()->json(['statusCode' => 200, 'message' => 'Your OTP is correct']);
        } else {
            return response()->json(['statusCode' => 401, 'message' => 'Your OTP not correct']);
        }
    }
    public function resetPassword(Request $request)
    {
        $data = $request->all();
        if (!isset($data['password']) || !isset($data['confirm_password'])) {
            return response()->json(['statusCode' => 404, 'message' => 'Please fill all fields']);
        } else if ($data['password'] !== $data['confirm_password']) {
            return response()->json(['statusCode' => 401, 'message' => 'Password does not match']);
        } else {
            $user = User::where('email', $data['email'])->first();
            $user->update(['password' => Hash::make($data['password'])]);
            return response()->json(['statusCode' => 200, 'message' => 'Password Reset Success']);
        }
    }
    public function profile(Request $request)
    {

        if ($request->isMethod('POST')) {
            if (count(User::where('token', $request->bearerToken())->get()) > 0) {
                $user = User::find(User::where('token', $request->bearerToken())->first()->id);
                $data = $request->all();
                $validator = Validator::make($data, [
                    'email' => 'email',
                    'mobile'=>'numeric'
                ]);
                if ($validator->fails()) {
                    return response()->json(['statusCode' => 422, 'message' => $validator->errors()->first()]);
                }else{
                    if ($request->hasFile('image')) {
                        $image = $request->file('image');
                        $reimage = time() . '.' . $image->getClientOriginalExtension();
                        $dest = public_path('/imgs');
                        $image->move($dest, $reimage);
                        $data['image'] = url('imgs/' . $reimage);
                        File::delete(public_path('imgs/' . $user['image']));
                        $user->update($data);
                    } else {
                        $user->update($data);
                    }

                    return response()->json(['statusCode' => 200, 'message' => 'Thay đổi thông tin thành công', 'data'=>['user'=>$user]]);
                }
            } else {
                return response()->json(['statusCode' => 401, 'message' => 'Unauthorized']);
            }
        }
        if (count(User::where('token', $request->bearerToken())->get()) > 0) {
            $user = User::find(User::where('token', $request->bearerToken())->first()->id);
            return response()->json(['statusCode' => 200, 'data' => ['user' => $user, 'count_infor' => count(Notify::all()), 'count_cart' => 0]]);
        } else {
            return response()->json(['statusCode' => 401, 'message' => 'Unauthorized']);
        }
    }
    public function changePassword(Request $request)
    {
        if (count(User::where('token', $request->bearerToken())->get()) > 0) {
            $data = $request->all();
            $user = User::find(User::where('token', $request->bearerToken())->first()->id);
            if (Hash::check($data['password'], $user['password'])) {
                if ($data['new_password'] === $data['confirm_password']&&count_chars($data['new_password'])===count_chars($data['confirm_password'])) {
                    $user->update(['password' => Hash::make($data['new_password'])]);
                    return response()->json(['statusCode' => 200, 'message' => 'Đổi mật khẩu thành công']);
                } else {
                    return response()->json(['statusCode' => 401, 'message' => 'Mật khẩu không trùng khớp']);
                }
            } else {
                return response()->json(['statusCode' => 401, 'message' => 'Mật khẩu cũ không đúng']);
            }
        } else {
            return response()->json(['statusCode' => 401, 'message' => 'Unauthorized']);
        }
    }
    public function registerProfessional(Request $request)
    {
        $data = $request->all();
        $userInfo = Auth::user();
        $user = User::find($userInfo->id);
        if ($data['type'] == 1) {
            return response()->json(['statusCode' => 400, 'message' => 'Đang là tài khoản thường']);
        }
        if ($data['type'] == 2 || $data['type'] == 3) {
            if ($request->hasFile('front_image') || $request->hasFile('back_image')) {
                $front_image = $request->file('front_image');
                $back_image= $request->file('back_image');
                $front_reimage = UploadService::upload('user', $front_image);
                $back_reimage = UploadService::upload('user', $back_image);
                $data['front_image'] = $front_reimage;
                $data['back_image'] = $back_reimage;
            }

            if ($request->hasFile('certificate_file')) {
                $certificate_file = $request->file('certificate_file');
                $certificate_reimage = UploadService::upload('certificate', $certificate_file);
                $data['certificate_file'] = $certificate_reimage;
            }
        }

        $user->update([
            'type' => $data['type'],
            'check' => 0,
            'front_image' => $data['front_image'] ?? '',
            'back_image' => $data['back_image'] ?? '',
            'certificate_file' => $data['certificate_file'] ?? '',
        ]);
        return response()->json(['statusCode' => 200, 'message' => 'Cập nhật chuyên gia thành công']);
    }
}
