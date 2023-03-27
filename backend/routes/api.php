<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::namespace('Api')->group(function(){
    //Users
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
    Route::post('/send-email', 'UserController@sendEmail');
    Route::post('/check-otp', 'UserController@checkOtp');
    Route::post('/reset-password', 'UserController@resetPassword');
    Route::post('/change-password', 'UserController@changePassword');
    //Home
    Route::get('/home', 'HomeController@index');
    Route::post('/search', 'HomeController@search');
    Route::match(['get','post'],'/filter', 'HomeController@filter');
    Route::get('/about-us', 'HomeController@aboutUs');
    Route::get('/policy', 'HomeController@policy');
    Route::get('/cities', 'HomeController@cities');
    Route::get('/districts', 'HomeController@districts');
    Route::get('/wards', 'HomeController@wards');
    //Courses
    Route::get('/courses', 'CourseController@index');
    Route::get('/detail/course', 'CourseController@detail');
    Route::get('/type/course', 'CourseController@typeCourse');
    //Books
    Route::get('/books', 'BookController@index');
    Route::get('/detail/book', 'BookController@detail');
    Route::post('/search/books', 'BookController@searchBooks');
    //News
    Route::get('/news', 'NewsController@index');
    Route::get('/detail/news', 'NewsController@detail');
    //Surveys
    Route::get('/surveys', 'SurveyController@index');
    Route::post('/send-survey', 'SurveyController@sendSurvey');


    Route::get('/questions/survey', 'SurveyController@questions');

    Route::get('/notifies', 'NotifyController@index');
    Route::match(['get','post'],'/detail/notify', 'NotifyController@detail');
    Route::match(['get','post'],'/profile', 'UserController@profile');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/logout', 'UserController@logout');
        Route::post('/register-professional', 'UserController@registerProfessional');

        Route::post('/add-cart/course', [\App\Http\Controllers\Api\CourseController::class, 'buyCourse']);
        Route::get('/list/course', [\App\Http\Controllers\Api\CourseController::class, 'list']);
        Route::post('/create/course', [\App\Http\Controllers\Api\CourseController::class, 'create']);
        Route::post( '/edit/course/{id}', [\App\Http\Controllers\Api\CourseController::class, 'edit']);
        Route::get( '/detail/course/{course}', [\App\Http\Controllers\Api\CourseController::class, 'detail']);
        Route::delete( '/delete/course/{course}', [\App\Http\Controllers\Api\CourseController::class, 'delete']);

        Route::post('/add-cart/book', [\App\Http\Controllers\Api\BookController::class, 'buyBook']);
    });
});
