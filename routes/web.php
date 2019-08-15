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

###超管后台
Route::get('/mouke_admin',function(){
    return view('admin.index');
});
#资讯添加
Route::get('/formation/add','Zi\FormationController@add');
#资讯添加执行
Route::post('/formation/add_do','Zi\FormationController@add_do');
#资讯列表
Route::get('/formation/list','Zi\FormationController@list');
#删除
Route::post('/formation/del','Zi\FormationController@del');
#修改
Route::get('/formation/update/{id}','Zi\FormationController@update');
#修改执行
Route::post('/formation/edit','Zi\FormationController@edit');

//Route::get('/index','Index\IndexController@index');



#分类资讯添加
Route::get('/cate_formation/add',function(){
    return view('information.cate_add');
});
Route::get('/index', function () {
    return view('teacher.index');
});
#分类添加执行
Route::post('/cate_do','Zi\FormationController@cate_do');
#分类资讯列表
Route::get('/cate_formation/list','Zi\FormationController@cate_list');
//课程分类添加页面
Route::get('/currcate/add','Curr\CurrCateController@add');
//检测课程分类名称唯一性
Route::post('/currcate/checkCateName','Curr\CurrCateController@checkCateName');
//课程分类添加处理
Route::post('/currcate/addHandle','Curr\CurrCateController@addHandle');
//课程分类列表
Route::get('/currcate/list','Curr\CurrCateController@list');
//修改课程分类页面
Route::get('/currcate/edit','Curr\CurrCateController@edit');
//修改课程分类处理
Route::post('/currcate/editHandle','Curr\CurrCateController@editHandle');
//即点即改分类名称
Route::post('/currcate/editCateName','Curr\CurrCateController@editCateName');
//删除课程分类
Route::post('/currcate/del','Curr\CurrCateController@del');
//课程章节添加页面
Route::get('/currchapter/add','Curr\CurrChapterController@add');
//检测章节名称唯一性
Route::post('/currchapter/checkchaptername','Curr\CurrChapterController@checkChapterName');
//课程章节添加处理
Route::post('currchapter/addHandle','Curr\CurrChapterController@addHandle');
//课程章节列表
Route::get('/currchapter/list','Curr\CurrChapterController@list');
//课程章节修改页面
Route::get('/currchapter/edit','Curr\CurrChapterController@edit');
//课程章节修改处理
Route::post('/currchapter/editHandle','Curr\CurrChapterController@editHandle');
//即点即改章节名称
Route::post('/currchapter/editChapterName','Curr\CurrChapterController@editChapterName');
//删除课程章节
Route::post('currchapter/del','Curr\CurrChapterController@del');

#分类删除
Route::get('/cate_del/{id}','Zi\FormationController@cate_del');
Route::get('/teacherlist','teacher\TeacherController@teacherlist');

Route::post('/teacherreview','teacher\TeacherController@teacherreview');
Route::post('/teacherreview1','teacher\TeacherController@teacherreview1');

Route::post('/teacherlock','teacher\TeacherController@teacherlock');
Route::post('/teacherlock1','teacher\TeacherController@teacherlock1');
Route::get('/lock','teacher\TeacherController@lock');

// Route::post('/teacherreview','teacher\TealistController@teacherreview');

#课程审核
    #视图
    Route::get('/course/audit','course\CourseController@audit');
    #审核通过
    Route::post('/audit_pass','course\CourseController@audit_pass');
    #审核不通过
    Route::post('/audit_no','course\CourseController@audit_no');
    #审核未通过列表
    Route::get('/course/audit/no','course\CourseController@audit_list_no');
#视频审核
    #视图
    Route::get('/video/audit','course\CourseController@video_audit');
    #点击 课程 展示章节
    Route::post('/curriculum','course\CourseController@curriculum');
    #点击 章节 展示课时
    Route::post('/class_hour','course\CourseController@class_hour');
    #点击 课时 展示视频
    Route::post('/getvideo','course\CourseController@getvideo');
    #点击 审核通过
    Route::post('/video_pass','course\CourseController@video_pass');
    #点击 审核不通过
    Route::post('/video_no','course\CourseController@video_no');
