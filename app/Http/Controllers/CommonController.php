<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //商家信息
    public function businessInfo(){
        $userInfo = $_COOKIE['userInfo'];
        return $userInfo;
    }
}
