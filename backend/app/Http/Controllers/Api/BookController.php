<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookUser;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

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
            $data['status'] = 1;
            BookUser::create($data);
            return response()->json(['statusCode'=>200, 'message'=>'Thêm giỏ hàng thành công']);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Bạn cần đăng nhập tài khoản để thực hiện chức năng này']);
        }
    }
//    public function detail(Request $request){
//        $data=$request->all();
//        $book=Book::with('bookChapter')->find($data['id']);
//        $book['admin_image']=Admin::find($book['admin_id'])->image;
//        $book['description']=html_entity_decode($book['description']);
//        return response()->json(['statusCode'=>200, 'data'=>['book'=>$book]]);
//    }
    public function searchBooks(Request $request){
        $data=$request->all();
        $books=Book::orWhere('title', 'like', '%'. $data['query']. '%')->orWhere('admin_name', 'like', '%'. $data['query']. '%')->orWhere('sold', 'like', '%'. $data['query']. '%')->orWhere('opening_date', 'like', '%'. date('Y-m-d', strtotime($data['query'])). '%')->get();
        $books_new=array();
        foreach($books as $book){
            array_push($books_new, ['id'=>$book['id'],'admin_name'=>Admin::find($book['admin_id'])->name, 'book_image'=>$book['image'], 'admin_image'=>Admin::find($book['admin_id'])->image,  'sold'=>$book['sold'], 'title'=>$book['title'], 'type'=>$book['type'], 'bought'=>0]);
        }
        return response()->json(['statusCode'=>200, 'data'=>['books'=>$books_new]]);
    }

    public function list(Request $request)
    {
        $userInfo = Auth::user();
        return Course::query()
            ->where('creator_id', $userInfo->id)
            ->get()
            ->toArray();
    }

    public function detail(Course $course, Request $request){
        return response()->json(['statusCode'=>200, 'data'=>['course'=>$course]]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) {
            return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
        } else {
            if (count(Category::where('id', $data['category_id'])->get()) == 0) {
                $category = Category::create(['name' => ucfirst(strtolower($data['category_id']))]);
                $data['category_id'] = $category['id'];
            }
            $data['creator_id'] = Auth::guard('api')->user()->id;
            $data['creator_name'] = Auth::guard('api')->user()->name;
            if (isset($data['image'])) {
                Course::create($data);
            } else {
                return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
            }
        }
        return response()->json(['statusCode' => 200, 'message' => 'Tạo khoá học thành công']);
    }

    public function edit(Request $request, $id)
    {
        $course = Course::find($id);
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'image.*' => 'image|mimes:jpeg,jpg,png',
            ]);
            if ($validator->fails()) {
                return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
            } else {
                if(count(Category::where('id',$data['category_id'])->get())==0){
                    $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
                    $data['category_id']=$category['id'];
                }
                $data['creator_id'] = Auth::guard('user')->user()->id;
                $data['creator_name'] = Auth::guard('user')->user()->name;
                if (isset($data['image'])) {
                    $course->update($data);
                    return response()->json(['statusCode' => 200, 'message' => 'Chỉnh Sửa Thành Công Khóa Học']);
                } else {
                    return response()->json(['statusCode' => 400, 'message' => 'Vui lòng nhập ảnh']);
                }
            }
        }
        return response()->json(['statusCode'=>200, 'message' => 'Cập nhập khoá học thành công']);
    }

    public function delete(Course $course)
    {
        try {
            $course->delete();
            return response()->json(['statusCode'=>200, 'message' => 'Xoá khoá học thành công']);
        } catch (\Exception $exception) {
            return response()->json(['statusCode'=>400, 'message' => 'Xoá khoá học không thành công']);
        }



    }
}
