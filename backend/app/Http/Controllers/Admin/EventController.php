<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
class EventController extends Controller
{
    public function index(Request $request)
    {
      $events = Event::all();
      return View('events.index', compact('events'));
    }
    public function create(Request $request)
    {
      if ($request->isMethod('POST')) {
        $data = $request->all();
        // dd($data);
        $validator = Validator::make($data, [
          'image.*' => 'image|mimes:jpeg,jpg,png'
        ]);
        if ($validator->fails()) {
          ALert::error('Lỗi', $validator->errors()->first());
          return redirect()->back();
        } else {
          if (isset($data['image'])) {
            Event::create($data);
            ALert::success('Thành công', 'Tạo Thành Công Sự Kiện');
            return redirect('/admin/events');
          } else {
            ALert::error('Lỗi', 'Thiếu Ảnh');
            return redirect()->back();
          }
        }
      }
      return view('events.create');
    }
    public function edit(Request $request, $id)
    {
      $event = Event::find($id);
  
      if ($request->isMethod('POST')) {
        $data = $request->all();
        $validator = Validator::make($data, [
          'image.*'=>'image|mimes:jpg,jpeg,png'
        ]);
        if ($validator->fails()) {
          ALert::error('Lỗi', $validator->errors()->first());
          return redirect()->back();
        } else {
          if (isset($data['image'])) {
            $event->update($data);
            ALert::success('Thành công', 'Chỉnh Sửa Thành Công Sự Kiện');
            return redirect('/admin/events');
          } else {
            ALert::error('Lỗi', 'Thiếu Ảnh');
            return redirect()->back();
          }
        }
      }
      return view('events.edit', compact('event'));
    }
    public function delete(Request $request, $id)
    {
      Event::find($id)->delete();
      ALert::success('Thành công', 'Xóa Sự Kiện Thành Công');
      return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
      $data = $request->all();
      Event::whereIn('id', explode(",", $data['ids']))->delete();
      return response()->json(['status' => true]);
    }
}
