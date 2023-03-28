<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Banner;
class UserController extends Controller
{
    public function index(){
        $users=User::all();
        $banner=Banner::first();
        return View('users.index', compact('users', 'banner'));
    }
    public function delete(Request $request, $id){
        User::find($id)->delete();
        ALert::success('Thành công', 'Xóa Người Dùng Thành Công');
        return redirect()->back();
    }

    public function deleteAll(Request $request){
        $data=$request->all();
        User::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
    }

    public function detail(User $user)
    {
        return View('users.edit', compact('user'));
    }

    public function checkAccountValid(User $user, Request $request)
    {
        $check = $request->get('check');
        $user->update(['check' => $check]);
        ALert::success('Thành công', 'Đã phê duyệt Thành Công');
        return redirect()->back();
    }
}
