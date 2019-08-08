<?php

namespace App\Http\Controllers\Zi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormationController extends Controller
{
    #资讯列表
    public function list(){
        return view('information.list');
    }
    #分类资讯列表
    public function cate_list(){
        return view('information.cate_list');
    }
}
