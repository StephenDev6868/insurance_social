<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
class NewsController extends Controller
{
    public function index(){
        $news=News::paginate(20);
        foreach($news as $item){
            $item['description']=html_entity_decode($item['description']);
        }
        return response()->json(['statusCode'=>200, 'data'=>['news'=>$news]]);
    }
    public function detail(Request $request){
        $data=$request->all();
        $news=News::find($data['id']);
        $news['description']=html_entity_decode($news['description']);
        return response()->json(['statusCode'=>200, 'data'=>['news'=>$news]]);
    }
    public function searchNews(Request $request){
        $data=$request->all();
        $news=News::orWhere('title', 'like', '%'. $data['query']. '%')->orWhere('admin_name', 'like', '%'. $data['query']. '%')->orWhere('sold', 'like', '%'. $data['query']. '%')->orWhere('opening_date', 'like', '%'. date('Y-m-d', strtotime($data['query'])). '%')->get();
        $news_new=array();
        foreach($news as $new){
            $new['description']=html_entity_decode($new['description']);
        }
        return response()->json(['statusCode'=>200, 'data'=>['news'=>$news_new]]);
    }
}
