<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\SurveyUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class SurveyController extends Controller
{
    public function index(Request $request){
        if(count(User::where('token', $request->bearerToken())->get())>0){
            $surveys=Survey::paginate(20);
            foreach($surveys as $survey){
                $survey['number_question']=count(Question::where('survey_id',$survey['id'])->get());
                $surveyEvent=SurveyUser::where('survey_id',$survey['id'])->where('user_id', User::where('token', $request->bearerToken())->first()->id)->get();
                $surveyEvent1=SurveyUser::where('survey_id',$survey['id'])->where('user_id', User::where('token', $request->bearerToken())->first()->id)->first();
                $survey['check']=(count($surveyEvent)>0)?1:0;
                $survey['number_question_user_did']=(count($surveyEvent)>0)?$surveyEvent1->number_question_user_did:0;
            }
            return response()->json(['statusCode'=>200, 'data'=>['surveys'=>$surveys]]);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Unauthorized']);
        }
    }
    public function questions(Request $request){
        if(count(User::where('token', $request->bearerToken())->get())>0){
            $data=$request->all();
            $questions=Question::where('survey_id', $data['survey_id'])->get();
            foreach($questions as $question){
                $question['answer']=explode("|||",$question['answer']);
            }
            return response()->json(['statusCode'=>200, 'data'=>['questions'=>$questions]]);
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Unauthorized']);
        }
    }
    public function sendSurvey(Request $request){
        if(count(User::where('token', $request->bearerToken())->get())>0){
            $data=$request->all();
            $data['user_id']=User::where('token', $request->bearerToken())->first()->id;
            $data['number_question_user_did']=count($data['question_id']);
            if(count(SurveyUser::where('user_id', $data['user_id'])->where('survey_id', $data['survey_id'])->get())==0){
                SurveyUser::create($data);
                return response()->json(['statusCode'=>200, 'message'=>'Gửi khảo sát thành công']);
            }else{
                return response()->json(['statusCode'=>500, 'message'=>'Bạn đã làm khảo sát này']);
            }
            
        }else{
            return response()->json(['statusCode'=>401, 'message'=>'Unauthorized']);
        }
    }
}
