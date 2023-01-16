<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookUser;
use App\Models\Admin;
class BookController extends Controller
{
    public function index(){
        $books=Book::with('bookChapter')->get();
        foreach($books as $book){
            $book['description']=html_entity_decode($book['description']);
        }
        return response()->json(['statusCode'=>200, 'data'=>['books'=>$books]]);
    }
    public function buyBook(Request $request){
        $data=$request->all();
        if(Auth::check()){
            $data['user_id']=Auth::user()->id;
            BookUser::create($data);
            return response()->json(['statusCode'=>200, 'message'=>'Thêm giỏ hàng thành công']);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Bạn cần đăng nhập tài khoản để thực hiện chức năng này']);
        }
    }
    public function detail(Request $request){
        $data=$request->all();
        $book=Book::with('bookChapter')->find($data['id']);
        $book['admin_image']=Admin::find($book['admin_id'])->image;
        $book['description']=html_entity_decode($book['description']);
        return response()->json(['statusCode'=>200, 'data'=>['book'=>$book]]);
    }
    public function searchBooks(Request $request){
        $data=$request->all();
        $books=Book::orWhere('title', 'like', '%'. $data['query']. '%')->orWhere('admin_name', 'like', '%'. $data['query']. '%')->orWhere('sold', 'like', '%'. $data['query']. '%')->orWhere('opening_date', 'like', '%'. date('Y-m-d', strtotime($data['query'])). '%')->get();
        $books_new=array();
        foreach($books as $book){
            array_push($books_new, ['id'=>$book['id'],'admin_name'=>Admin::find($book['admin_id'])->name, 'book_image'=>$book['image'], 'admin_image'=>Admin::find($book['admin_id'])->image,  'sold'=>$book['sold'], 'title'=>$book['title'], 'type'=>$book['type'], 'bought'=>0]);
        }
        return response()->json(['statusCode'=>200, 'data'=>['books'=>$books_new]]);
    }
}
