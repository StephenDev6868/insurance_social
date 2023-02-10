<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use RealRashid\SweetAlert\Facades\Alert;
class QuestionController extends Controller
{
    public function index(Request $request, $id){
        $questions=Question::where('survey_id',$id)->get();
        return View('questions.index', compact('questions', 'id'));
    }
    public function create(Request $request, $id){
        if($request->isMethod('POST')){
            $data=$request->all();
            if(isset($data['answer'])){
            $data['answer']=implode("|||", $data['answer']);
            }
            $data['survey_id']=$id;
            Question::create($data);
            ALert::success('Thành công', 'Tạo Câu Hỏi Thành Công');
            return redirect('/admin/questions/survey/'.$id);
        }
        return View('questions.create', compact('id'));
    }
    public function edit(Request $request, $question_id, $id){
        $question=Question::find($question_id);
        if($request->isMethod('POST')){
            $data=$request->all();
            if(isset($data['answer'])){
            $data['answer']=implode("|||", $data['answer']);
            }
            $data['survey_id']=$id;
            $question->update($data);
            ALert::success('Thành công', 'Cập Nhật Câu Hỏi Thành Công');
            return redirect('/admin/questions/survey/'.$id);
        }
        return View('questions.edit', compact('id', 'question_id', 'question'));
    }
    public function delete(Request $request, $id){
        Question::find($id)->delete();
        ALert::success('Thành công', 'Xóa Câu Hỏi Thành Công');
        return redirect()->back();
      }
      public function deleteAll(Request $request){
        $data=$request->all();
        Question::whereIn('id', explode(",",$data['ids']))->delete();
        return response()->json(['status' => true]);
      }
}
