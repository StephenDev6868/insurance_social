<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
}
