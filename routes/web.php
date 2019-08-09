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

Route::get('/index','Index\IndexController@index');



#分类资讯添加
Route::get('/cate_formation/add',function(){
    return view('information.cate_add');
});
#分类添加执行
Route::post('/cate_do','Zi\FormationController@cate_do');
#分类资讯列表
Route::get('/cate_formation/list','Zi\FormationController@cate_list');
#分类删除
Route::get('/cate_del/{id}','Zi\FormationController@cate_del');
