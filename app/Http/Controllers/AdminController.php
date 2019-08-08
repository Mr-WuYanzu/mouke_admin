<?php

namespace App\Http\Controllers;

use App\goods\Goods;
use App\Token;
use App\user\Business;
use App\user\ShopOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
class AdminController extends CommonController
{
    //首页
    public function index(){
        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);
        return view('admin',['businessInfo'=>$businessInfo]);
    }

    //商品添加页面
    public function goodsAdd(){
        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);
        return view('goods',['businessInfo'=>$businessInfo]);
    }

    //商品列表
    public function goodslist(){

        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);

        $token = $_COOKIE['token']??null;
        $shop_id = $businessInfo['shop_id']??null;
        //商户商品接口地址
        $url='http://shop.admin.com/shop_goods';
        $ch = curl_init();
        $data = [
            'token'=>$token,
            'shop_id'=>$shop_id
        ];
        $str = http_build_query($data);
        //设置参数
        $arr=[
            CURLOPT_URL=>$url,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$str,
            CURLOPT_RETURNTRANSFER=>true
        ];
        curl_setopt_array($ch,$arr);
        //发起请求
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res,true);
        $data=[];
        if($res){
            if($res['status']==1000){
                $data = $res['data'];
            }
        }
        return view('goodslist',['businessInfo'=>$businessInfo,'data'=>$data]);
    }

    //订单列表
    public function orderlist(){
        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);

        //查询商家订单表
        $token = $_COOKIE['token']??null;
        //拿用户传来的token查询数据库
        $tokenInfo = Token::where(['token'=>$token,['expire','>',time()]])->first();
        if(empty($tokenInfo)){
            echo '请登录后访问';
        }
        //根据用户id查找商家id
        $tokenInfo = collect($tokenInfo)->toArray();
        $user_id = $tokenInfo['user_id'];
//        查询商家 获取商家id
        $shop_id = Business::where('user_id',$user_id)->value('shop_id');
        #根据商家id来确定查找哪张表
        $table = 'shop_order_son_business_0'.($shop_id%10);
        $order_model = new ShopOrder();
        $order_model->table=$table;
        $shop_order = $order_model->get();
        return view('orderlist',['businessInfo'=>$businessInfo,'shop_order'=>$shop_order]);
    }

    //已结算订单
    public function orderAccess(){
        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);
        return view('orderAccess',['businessInfo'=>$businessInfo]);
    }

    //未结算订单
    public function orderNoAccess(){
        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);
        return view('orderNoAccess',['businessInfo'=>$businessInfo]);
    }
}
