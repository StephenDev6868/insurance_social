<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\Book;
use App\Models\News;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Event;
use App\Models\Policy;
use App\Models\AboutUs;
use App\Models\Notify;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Vanthao03596\HCVN\Models\Province;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Ward;
function charlimit($string, $limit) {

    return substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : '');
}
class HomeController extends Controller
{

    public function pagination($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function index(Request $request){
        // dd($request->bearerToken());
        // if(count(User::where('token', $request->bearerToken())->get())>0){
        //     $user=User::where('token', $request->bearerToken())->first();
        //     $count_infor=count(Notify::all());
        //     $count_cart=0;
        // }else{
        //     $user="";
        //     $count_infor=0;
        //     $count_cart=0;
        // }
        $banner=Banner::first();
        $banner['banner_image']=explode("|||",$banner['banner_image']);
        $banner['banner_link']=explode("|||",$banner['banner_link']);
        $courses=Course::orderBy('sold', 'desc')->limit(6)->get();
        $courses_new=array();
        foreach($courses as $course){
            array_push($courses_new,
                ['id'=>$course['id'],
                'admin_name'=> optional(Admin::find($course['admin_id']))->name,
                'course_image'=>$course['image'],
                'admin_image'=> optional(Admin::find($course['admin_id']))->image,
                'sold'=>$course['sold'],
                'opening_date'=>isset($course['opening_date'])?date('d/m/Y', strtotime($course['opening_date'])):date('d/m/Y', strtotime($course['created_at'])),
                'title'=>$course['title'], 'type'=>$course['type'], 'bought'=>0]);
        }
        $books=Book::orderBy('sold', 'desc')->limit(6)->get();
        $books_new=array();
        foreach($books as $book){
            array_push($books_new, ['id'=>$book['id'],'admin_name'=>Admin::find($book['admin_id'])->name, 'book_image'=>$book['image'], 'admin_image'=>Admin::find($book['admin_id'])->image,  'sold'=>$book['sold'], 'title'=>$book['title'], 'type'=>$book['type'], 'bought'=>0]);
        }
        $news=News::orderBy('id', 'desc')->limit(3)->get();
        foreach($news as $new){
            $new['description']=html_entity_decode($new['description']);
        }
        $event=Event::orderBy('id', 'desc')->get();
        return response()->json(['statusCode'=>200, 'data'=>['banner'=>$banner, 'courses'=>$courses_new, 'books'=>$books_new, 'news'=>$news, 'event'=>$event]]);
    }

    public function search(Request $request){
        $data=$request->all();
        if(!empty($data['category_id'])){
            $courses=Course::where('category_id', $data['category_id'])
                ->where('title', 'like', '%'. ( ($data['query'] ?? '')  ?? ''). '%')
                ->orWhere('admin_name', 'like', '%'. ( ($data['query'] ?? '')  ?? '') . '%')
                ->where('category_id', $data['category_id'])
                ->orWhere('sold', 'like', '%'. ( ($data['query'] ?? '')  ?? '') . '%')
                ->where('category_id', $data['category_id'])
                ->orWhere('opening_date', 'like', '%'. date('Y-m-d', strtotime(( ($data['query'] ?? '')  ?? ''))). '%')
                ->where('category_id', $data['category_id'])
                ->get();
        }else{
            $courses=Course::orWhere('title', 'like', '%'.  ($data['query'] ?? '') . '%')->orWhere('admin_name', 'like', '%'.  ($data['query'] ?? '') . '%')->orWhere('sold', 'like', '%'.  ($data['query'] ?? '') . '%')->orWhere('opening_date', 'like', '%'. date('Y-m-d', strtotime( ($data['query'] ?? '') )). '%')->get();
        }
        $courses_new=array();
        foreach($courses as $course){
            $courses_new[] = ['id' => $course['id'], 'admin_name' => optional(Admin::find($course['admin_id']))->name, 'course_image' => $course['image'], 'admin_image' => Admin::find($course['admin_id'])->image, 'sold' => $course['sold'], 'opening_date' => isset($course['opening_date']) ? date('d/m/Y', strtotime($course['opening_date'])) : date('d/m/Y', strtotime($course['created_at'])), 'title' => $course['title'], 'type' => $course['type'], 'bought' => 0];
        }
        // $books=Book::where('title', 'like', '%'.  ($data['query'] ?? '') .'%')->orWhere('admin_name', 'like', '%'.  ($data['query'] ?? '') . '%')->orWhere('sold', 'like', '%'.  ($data['query'] ?? '') . '%')->get()->toArray();
        // $news=News::where('title', 'like', '%'.  ($data['query'] ?? '') . '%')->orWhere('created_at', 'like', '%'. date('Y-m-d', strtotime( ($data['query'] ?? '') )). '%')->get()->toArray();
        // $alls=array_merge($courses, $books, $news);
        $data=$this->pagination($courses_new);
        return response()->json(['statusCode'=>200, 'data'=>['count'=>count($courses),'data'=>$data]]);
    }
    public function filter(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $courses=Course::where('category_id', $data['category_id'])->where('query',  ($data['query'] ?? '') )->get()->toArray();
            $courses_new=array();
        foreach($courses as $course){
            array_push($courses_new, ['admin_name'=>Admin::find($course['admin_id'])->name, 'course_image'=>$course['image'], 'admin_image'=>Admin::find($course['admin_id'])->image,  'sold'=>$course['sold'], 'opening_date'=>date('d/m/Y', strtotime($course['opening_date'])), 'title'=>$course['title'], 'type'=>$course['type'], 'bought'=>0]);
        }
            // $books=Book::where('category_id', $data['category_id'])->get()->toArray();
            // $news=News::where('category_id', $data['category_id'])->get()->toArray();
            // $alls=array_merge($courses, $books, $news);
            $data=$this->pagination($courses_new);
            return response()->json(['statusCode'=>200, 'data'=>['count'=>count($courses),'data'=>$data]]);
        }
        return response()->json(['statusCode'=>200, 'data'=>['category'=>Category::all()]]);
    }
    public function policy(){
        return response()->json(['statusCode'=>200, 'data'=>['policy'=>Policy::first()]]);
    }
    public function aboutUs(){
        return response()->json(['statusCode'=>200, 'data'=>['about-us'=>AboutUs::first()]]);
    }
    public function cities(){
        $cities = Province::get();
        $districts = District::get();
        $wards = Ward::get();
        return response()->json(['statusCode'=>200, 'data'=>['cities'=>$cities]]);
    }
    public function districts(Request $request){
        $data=$request->all();
        $districts=Province::with('districts')->find($data['city_id']);
        return response()->json(['statusCode'=>200, 'data'=>['districts'=>$districts]]);
    }
    public function wards(Request $request){
        $data=$request->all();
        $districts=Province::with('districts')->find($data['city_id']);
        $wards=$districts->with('wards')->find($data['district_id']);
        return response()->json(['statusCode'=>200, 'data'=>['wards'=>$wards]]);
    }

    public function listCategory(Request $request)
    {
        $type = $request->input('type');
        if ($type == 1) {
            return response()->json(['statusCode'=>200, 'data'=>['categorys'=> CourseCategory::all()]]);
        } else {
            return response()->json(['statusCode'=>200, 'data'=>['categorys'=> BookCategory::all()]]);
        }
    }
}
