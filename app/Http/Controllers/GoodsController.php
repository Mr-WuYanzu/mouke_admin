<?php

namespace App\Http\Controllers;

use App\goods\Goods;
use App\GoodsAuto;
use App\Token;
use App\user\Business;
use App\user\User;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    //商品添加
    public function goodsAdd(Request $request){
        $token = $request->post('token');
        //验证商家身份
        $res = $this->_checkBusiness($token);//返回商家信息
        if ($res === false) {
            return ['status' => 105, 'msg' => '您还不是商家'];
            die;
        }
        //判断商家的状态
        if ($res->status != 1) {
            if ($res->status == 2) {
                return ['status' => 105, 'msg' => '您已锁定请解锁后登录'];
                die;
            }
            if ($res->status == 3) {
                return ['status' => 105, 'msg' => $res->account];
                die;
            }
        }
        $goods_name = $request->post('goods_name'); //商品名
        $goods_price = $request->post('goods_price');//商品单价
        $goods_stock = $request->post('goods_stock');//商品库存
        $goods_desc = $request->post('goods_desc');//商品介绍
        $goods_img = $request->post('goods_img');//商品图片
        if (empty($goods_price) || empty($goods_name) || empty($goods_desc) || empty($goods_stock)) {
            return ['status' => 105, 'msg' => '必填项不能为空'];
            die;
        }
        $data = [
            'goods_name' => $goods_name,
            'shop_id' => $res->shop_id,
            'goods_stock' => $goods_stock,
            'goods_desc' => $goods_desc,
            'goods_price' => $goods_price,
            'goods_img' => $goods_img,
            'goods_status' => 3,
        ];
        //获取下一条加入的id
        $goods_id = GoodsAuto::insertGetId(['id' => null]);
        if ($goods_id) {
//            根据商家id进行分表 $res 是上面查到的商家信息
            $num = ($res->shop_id % 5);
            //确定表名
            $table = 'shop_goods_' . $num;
            $goods_model = new Goods();
            //更改当前model的表
            $goods_model->table = $table;
            $res = $goods_model->insert($data);
            if ($res) {
                return ['status' => 1000, 'msg' => '添加成功，请等待审核'];
                die;
            } else {
                return ['status' => 106, 'msg' => '添加失败，请重试'];
                die;
            }
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


    //商品下架
    public function goodsDown(Request $request){
        $goods_id = $request->post('goods_id');
        $shop_id = $request->post('shop_id');
        $token = $request->post('token');
        if(empty($token)){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $res = $this->_checkBusiness($token);
        if($res === false){
            return ['status'=>402,'msg'=>'请登录'];
        }else if($res->shop_id != $shop_id){
            return ['status'=>402,'msg'=>'请登录'];
        }
        if(empty($goods_id) || empty($shop_id)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $where=[
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id
        ];
//        根据shopid确定商品在那个表
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        $goodsInfo = $goods_model->where($where)->first();
        if(empty($goodsInfo)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $res = $goods_model->where($where)->update(['goods_status'=>2]);
        if($res){
            return ['status'=>1000,'msg'=>'操作成功'];
        }else{
            return ['status'=>1001,'msg'=>'操作失败'];
        }

    }

    //商品上架
    public function goodsTop(Request $request){
        $goods_id = $request->post('goods_id');
        $shop_id = $request->post('shop_id');
        $token = $request->post('token');
        if(empty($token)){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $res = $this->_checkBusiness($token);
        if($res === false){
            return ['status'=>402,'msg'=>'请登录'];
        }else if($res->shop_id != $shop_id){
            return ['status'=>402,'msg'=>'请登录'];
        }
        if(empty($goods_id) || empty($shop_id)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $where=[
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id
        ];
//        根据shopid确定商品在那个表
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        $goodsInfo = $goods_model->where($where)->first();
        if(empty($goodsInfo)){
            return ['status'=>103,'msg'=>'请选择更改的商品'];
        }
        $res = $goods_model->where($where)->update(['goods_status'=>3]);
        if($res){
            return ['status'=>1000,'msg'=>'操作成功,等待审核'];
        }else{
            return ['status'=>1001,'msg'=>'操作失败'];
        }

    }


    //返回商家商品信息
    public function shop_goods(Request $request){
        $token = $request->post('token');
        $shop_id = $request->post('shop_id');
        if(empty($token) || empty($shop_id)){
            return ['status'=>106,'msg'=>'请登录'];
        }
        //验证token
        $res = $this->_checkBusiness($token);
        if($res === false){
            return ['status'=>402,'msg'=>'请登录'];
        }else if($res->shop_id != $shop_id){
            return ['status'=>402,'msg'=>'请登录'];
        }

        //根据商家id确定商品所在的表名
        $table = 'shop_goods_'.($shop_id%5);
        $goods_model = new Goods();
        $goods_model->table=$table;
        //查询商品信息 根据商家id
        $goodsInfo = $goods_model->where(['shop_id'=>$shop_id])->get();
        $data = collect($goodsInfo)->toArray();
        if($data) {
            foreach ($data as $k => $v) {
                if ($v['goods_status'] == 1) {
                    $data[$k]['goods_status'] = '已上架';
                } else if ($v['goods_status'] == 2) {
                    $data[$k]['goods_status'] = '已下架';
                } else if ($v['goods_status'] == 3) {
                    $data[$k]['goods_status'] = '待审核';
                } else if ($v['goods_status'] == 4) {
                    $data[$k]['goods_status'] = '审核未通过';
                } else if ($v['goods_status'] == 5) {
                    $data[$k]['goods_status'] = '已被管理员强制下架';
                }
            }
        }
        return ['status' =>1000,'msg'=>'ok','data'=>$data];
    }
}
