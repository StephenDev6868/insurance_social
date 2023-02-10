<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookChapter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ChapterBookController extends Controller
{
    public function index(Request $request, $id){
        $chapters=BookChapter::where('book_id', $id)->get();
        return View('books.chapter', compact('chapters', 'id'));
    }
    public function create(Request $request, $id){
        $data=$request->all();
        $data['book_id']=$id;
        BookChapter::create($data);
        ALert::success('Thành công', 'Tạo Chương Sách Thành Công');
        return redirect()->back();
    }
    public function edit(Request $request, $id){
        $chapter=BookChapter::find($id);
        $data=$request->all();
        $chapter->update($data);
        ALert::success('Thành công', 'Chỉnh Sửa Chương Sách Thành Công');
        return redirect()->back();
    }
    public function delete(Request $request, $id){
        BookChapter::find($id)->delete();
        ALert::success('Thành công', 'Xóa Chương Sách Thành Công');
        return redirect()->back();
      }
      public function deleteAll(Request $request){
        $data=$request->all();
        BookChapter::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
      }
}
