<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use App\Models\Category;
class BookController extends Controller
{
    public function index(Request $request)
  {
    $books = Book::all();
    $banner=Banner::first();
    return View('books.index', compact('books', 'banner'));
  }
  public function create(Request $request)
  {
    $categories=Category::all();
    if ($request->isMethod('POST')) {
      $data = $request->all();
      // dd($data);
      if(count(Category::where('id',$data['category_id'])->get())==0){
        $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
        $data['category_id']=$category['id'];
        $data['category_name']=$category['name'];
      }else{
        $data['category_name']=Category::find($data['category_id'])->name;
      }
      $data['admin_id'] = Auth::guard('admin')->user()->id;
        $data['admin_name'] = Auth::guard('admin')->user()->name;
      if(isset($data['image'])){
        Book::create($data);
        ALert::success('Thành công', 'Tạo Thành Công Sách');
        return redirect('/admin/books');
      }else{
        ALert::error('Lỗi', 'Thiếu Ảnh');
        return redirect()->back();
      }
      
    }
    return view('books.create', compact('categories'));
  }
  public function edit(Request $request, $id){
    $book=Book::find($id);
    $categories=Category::all();
    if($request->isMethod('POST')){
      $data=$request->all();
      if(count(Category::where('id',$data['category_id'])->get())==0){
        $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
        $data['category_id']=$category['id'];
        $data['category_name']=$category['name'];
      }else{
        $data['category_name']=Category::find($data['category_id'])->name;
      }
      $data['admin_id'] = Auth::guard('admin')->user()->id;
        $data['admin_name'] = Auth::guard('admin')->user()->name;
      if(isset($data['image'])){
        $book->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Thành Công Sách');
        return redirect('/admin/books');
      }else{
        ALert::error('Lỗi', 'Thiếu Ảnh');
        return redirect()->back();
      }
      
    }
    return view('books.edit', compact('book', 'categories'));
  }
  public function delete(Request $request, $id){
    Book::find($id)->delete();
    ALert::success('Thành công', 'Xóa Sách Thành Công');
    return redirect()->back();
  }
  public function deleteAll(Request $request){
    $data=$request->all();
    Book::whereIn('id', explode(",",$data['ids']))->delete();
    return response()->json(['status' => true]);
  }
  
}
