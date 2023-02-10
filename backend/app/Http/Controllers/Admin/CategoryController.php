<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;
class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return view('categories.index', compact('categories'));
    }
    public function create(Request $request){
        $data=$request->all();
        Category::create($data);
        ALert::success('Thành công', 'Tạo Danh Mục Thành Công');
        return redirect()->back();
    }
    public function edit(Request $request, $id){
        $category=Category::find($id);
        $data=$request->all();
        $category->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Danh Mục Thành Công');
        return redirect()->back();
    }
    public function delete(Request $request, $id){
        Category::find($id)->delete();
        ALert::success('Thành công', 'Xóa Danh Mục Thành Công');
        return redirect()->back();
      }
      public function deleteAll(Request $request){
        $data=$request->all();
        Category::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
      }
}
