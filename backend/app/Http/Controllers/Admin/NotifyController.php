<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notify;
use App\Models\NotifyUser;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
class NotifyController extends Controller
{
    public function index(){
        $notifies=Notify::orderBy('id', 'desc')->get();
        return View('notifies.index', compact('notifies'));
    }
    public function create(Request $request){
        $data=$request->all();
        $notify=Notify::create($data);
        foreach(User::all() as $user){
            NotifyUser::create(['notify_id'=>$notify['id'], 'user_id'=>$user['id']]);
        }
        ALert::success('Thành công', 'Tạo Thông Báo Thành Công');
        return redirect()->back();
    }
    public function edit(Request $request, $id){
        $notify=Notify::find($id);
        $data=$request->all();
        $notify->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Thông Báo Thành Công');
        return redirect()->back();
    }
    public function delete(Request $request, $id){
        Notify::find($id)->delete();
        ALert::success('Thành công', 'Xóa Thông Báo Thành Công');
        return redirect()->back();
      }
      public function deleteAll(Request $request){
        $data=$request->all();
        Notify::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
      }
}
