<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Policy;
use RealRashid\SweetAlert\Facades\Alert;
class AdminController extends Controller
{
  public function login(Request $request)
  {
    // dd(Hash::make(1));
    if ($request->isMethod('post')) {
      $data = $request->all();
      if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
        ALert::success('Thành công', 'Đăng nhập thành công');
        return redirect('/admin/dashboard');
      } else {
        ALert::warning('Lỗi', 'Email hoặc mật khẩu không đúng');
        return redirect()->back();
      }
    }
    return View('login');
  }
  public function dashboard(Request $request)
  {
    $admin = Admin::find(Auth::guard('admin')->user()->id);
    return View('dashboard', compact('admin'));
  }
  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();
    ALert::success('Thành công', 'Đăng xuất thành công');
    return redirect('/admin');
  }
  public function account(Request $request)
  {
    $admin = Admin::find(Auth::guard('admin')->user()->id);
    if ($request->isMethod('post')) {
      $data = $request->all();
      if (isset($data['password']) && isset($data['confirm_password'])) {
        if ($data['password'] == $data['confirm_password']) {
          $data['password'] = Hash::make($data['password']);
          $admin->update($data);
          ALert::success('Thành công', 'Cập Nhật Thành Công');
          return redirect()->back();
        } else {
          ALert::warning('Lỗi', 'Mật khẩu không giống nhau');
          return redirect()->back();
        }
      }
      else if (empty($data['password']) && empty($data['confirm_password'])) {
        $data['password'] = $admin['password'];
        $admin->update($data);
        ALert::success('Thành công', 'Cập Nhật Thành Công');
        return redirect()->back();
      }
    }

    return View('account', compact('admin'));
  }
  public function aboutUs(Request $request){
    $aboutUs=AboutUs::first();
    if($request->isMethod('post')){
      $aboutUs->update($request->all());
      ALert::success('Thành công', 'Cập Nhật Thành Công');
      return redirect()->back();
    }
    return View('aboutus', compact('aboutUs'));
  }
  public function policy(Request $request){
    $policy=Policy::first();
    if($request->isMethod('post')){
      $policy->update($request->all());
      ALert::success('Thành công', 'Cập Nhật Thành Công');
      return redirect()->back();
    }
    return View('policy', compact('policy'));
  }
}