<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Category;
class NewsController extends Controller
{
  public function index(Request $request)
  {
    $news = News::all();
    return View('news.index', compact('news'));
  }
  public function create(Request $request)
  {
    $categories=Category::all();
    
    if ($request->isMethod('POST')) {
      $data = $request->all();
      if(count(Category::where('id',$data['category_id'])->get())==0){
        $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
        $data['category_id']=$category['id'];
      }
      News::create($data);
      ALert::success('Thành công', 'Tạo Thành Công Tin Tức');
      return redirect('/admin/news');
    }
    return view('news.create', compact('categories'));

  }
  public function edit(Request $request, $id)
  {
    $news = News::find($id);
    $categories=Category::all();
    if ($request->isMethod('POST')) {
      $data = $request->all();
      if(count(Category::where('id',$data['category_id'])->get())==0){
        $category=Category::create(['name'=>ucfirst(strtolower($data['category_id']))]);
        $data['category_id']=$category['id'];
      }
      if (isset($data['image'])) {
        $news->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Thành Công Tin Tức');
        return redirect('/admin/news');
      } else {
        ALert::error('Lỗi', 'Chỉnh Sửa Không Thành Công');
        return redirect()->back();
      }
    }
    return view('news.edit', compact('news', 'categories'));
  }
  public function delete(Request $request, $id)
  {
    News::find($id)->delete();
    ALert::success('Thành công', 'Xóa Khóa Học Thành Công');
    return redirect()->back();
  }
  public function deleteAll(Request $request)
  {
    $data = $request->all();
    News::whereIn('id', explode(",", $data['ids']))->delete();
    return response()->json(['status' => true]);
  }
}