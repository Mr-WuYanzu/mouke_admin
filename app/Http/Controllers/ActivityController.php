<?php

namespace App\Http\Controllers;

use App\goods\Goods;
use App\model\DisCount;
use App\model\Reduce;
use Illuminate\Http\Request;
use App\Token;
use App\user\User;
use App\user\Business;
use App\Http\Controllers\CommonController;

class ActivityController extends CommonController
{
    public function activity(){
        //商家信息
        $businessInfo = $this->businessInfo();
        $businessInfo = json_decode($businessInfo,true);

        $token = $_COOKIE['token']??null;
        $goods_id = intval($_GET['goods_id'])??null;
        if(empty($token)){
            echo '请登录';
        }
        if(empty($goods_id)){
            echo '请选择商品参与活动';
        }
        //获取商家信息
        $businessInfo = $this->_checkBusiness($token);
        if($businessInfo===false){
            echo '请登录';
        }
        $shop_id = $businessInfo['shop_id'];
        //根据商家id确定商品在哪个表
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        $goodsInfo = $goods_model->where(['goods_id'=>$goods_id,'shop_id'=>$shop_id])->first();
        if(empty($goodsInfo)){
            echo '商品不存在';
        }
        //验证商品状态
        if($goodsInfo['goods_status']==2){
            echo '商品已下架';
        }else if($goodsInfo['goods_status']==3){
            echo '商品待审核';
        }else if($goodsInfo['goods_status']==4){
            echo '审核未通过';
        }else if($goodsInfo['goods_status']==5){
            echo '商品已锁定';
        }
        return view('activity',['businessInfo'=>$businessInfo,'goodsInfo'=>$goodsInfo]);

    }

    //商品活动添加
    public function activityAdd(Request $request){
        $token = $_COOKIE['token']??null;
        if(empty($token)){
            return ['status'=>105,'msg'=>'请登录'];
        }
        $full_price = $request->post('full_price');
        $reduce_price = $request->post('reduce_price');
        $fullprice = $request->post('fullPrice');
        $discount = $request->post('discount');
        $goods_id = $request->post('goods_id');
        $expire = $request->post('expire');
        //验证用户
        $userInfo = $this->_checkBusiness($token);
        if($userInfo===false){
            return ['status'=>105,'msg'=>'请登录'];
        }
        $shop_id = $userInfo['shop_id'];
        //根据商家id确定商品在哪个表
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        $goodsInfo = $goods_model->where(['goods_id'=>$goods_id,'shop_id'=>$shop_id])->first();
        if(empty($goodsInfo)){
            return ['status'=>105,'msg'=>'商品不存在'];
        }
        //验证商品状态
        if($goodsInfo['goods_status']==2){
            return ['status'=>105,'msg'=>'商品已下架'];
        }else if($goodsInfo['goods_status']==3){
            return ['status'=>105,'msg'=>'商品待审核'];
        }else if($goodsInfo['goods_status']==4){
            return ['status'=>105,'msg'=>'审核未通过'];
        }else if($goodsInfo['goods_status']==5){
            return ['status'=>105,'msg'=>'商品已锁定'];
        }
        //验证通过添加活动
        //查询此商品有没有在参加此活动
        $arr=[
            'full_price'=>$full_price,
            'reduce_price'=>$reduce_price,
            'expire'=>strtotime($expire),
            'goods_id'=>$goods_id
        ];
        $reduceInfo = Reduce::where('goods_id',$goods_id)->first();
        if($reduceInfo){
            $res = Reduce::where('goods_id',$goods_id)->update($arr);
        }else{
            $res = Reduce::insert($arr);
        }
        if($res===false){
            return ['status'=>105,'msg'=>'添加失败'];
        }
        //查询此商品有没有参加过打折活动
        $data=[
            'full_price'=>$fullprice,
            'discount'=>$discount,
            'expire'=>strtotime($expire),
            'goods_id'=>$goods_id
        ];
        $discountInfo = DisCount::where('goods_id',$goods_id)->first();
        if($discountInfo){
            $result = DisCount::where('goods_id',$goods_id)->update($data);
        }else{
            $result = DisCount::insert($data);
        }
        if(!$result){
            return ['status'=>105,'msg'=>'添加失败'];
        }
        //活动添加成功将商品的参与活动状态改变
        $goods_result = $goods_model->where('goods_id',$goods_id)->update(['hot_activity'=>2]);
        if($goods_result!==false){
            return ['status'=>1000,'msg'=>'添加成功'];
        }else{
            return ['status'=>105,'msg'=>'添加失败'];
        }
    }

    //验证商家身份
    private function _checkBusiness($token){

        if(empty($token)){
            return false;die;
        }
        //拿用户传来的token查询数据库
        $tokenInfo = Token::where(['token'=>$token,['expire','>',time()]])->first();
        if(empty($tokenInfo)){
            return false;die;
        }

        $user_id = $tokenInfo->user_id;

        //拿到用户的id查用户表
        $userInfo = User::where(['user_id'=>$user_id])->first();
        if(empty($userInfo)){
            return false;die;
        }
        //如果查到此用户验证系用户是不是商家
        $businessInfo = Business::where('user_id',$user_id)->first();
        if(empty($businessInfo)){
            return false;die;
        }else{
            return $businessInfo;
        }
    }
}
