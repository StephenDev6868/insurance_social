<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notify;
use App\Models\NotifyUser;
use Illuminate\Http\Request;
use App\Models\User;
class NotifyController extends Controller
{
    public function index(Request $request){
        if(User::where('token', $request->bearerToken())->count()>0){
            $notifies=Notify::orderBy('id','desc')->paginate(20);
            foreach($notifies as $notify){
                $notify['description']=html_entity_decode($notify['description']);
                $notify['check']=NotifyUser::where('notify_id', $notify['id'])->where('user_id', User::where('token', $request->bearerToken())->first()->id)->first()->check;
            }
            return response()->json(['statusCode'=>200, 'data'=>['notifies'=>$notifies]]);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Unauthorized']);
        }
    }
    public function detail(Request $request){
        if(User::where('token', $request->bearerToken())->count()>0){
            $data=$request->all();
            $notify=Notify::find($data['id']);
            if($request->isMethod('post')){
                $notify_user_check=NotifyUser::where('notify_id', $notify['id'])->where('user_id', User::where('token', $request->bearerToken())->first()->id)->first();
                $notify_user_check->update(['check'=>1]);
                return response()->json(['statusCode'=>200, 'message'=>'Đã đọc']);
            }
            $notify['description']=html_entity_decode($notify['description']);
            $notify['check']=NotifyUser::where('notify_id', $notify['id'])->where('user_id', User::where('token', $request->bearerToken())->first()->id)->first()->check;
            return response()->json(['statusCode'=>200, 'data'=>['notify'=>$notify]]);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Unauthorized']);
        }
    }
}
