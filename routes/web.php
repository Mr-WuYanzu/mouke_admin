<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/index', function () {
    return view('teacher.index');
});

Route::get('/teacherlist','teacher\TeacherController@teacherlist');

Route::post('/teacherreview','teacher\TeacherController@teacherreview');
Route::post('/teacherreview1','teacher\TeacherController@teacherreview1');

Route::post('/teacherlock','teacher\TeacherController@teacherlock');
Route::post('/teacherlock1','teacher\TeacherController@teacherlock1');
Route::get('/lock','teacher\TeacherController@lock');

// Route::post('/teacherreview','teacher\TealistController@teacherreview');







