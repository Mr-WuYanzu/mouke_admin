<?php

namespace App\Http\Controllers;

use App\Token;
use App\user\Business;
use App\user\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //登录视图
    public function login(){
        return view('login');
    }
//    发送登录
    public function sendLogin(Request $request){
        $user_name = $request->post('user_name');
        $user_pwd = $request->post('user_pwd');
        //登录接口地址
        $url='http://shop.admin.com/loginDo';
        $ch = curl_init();
        $data = [
            'user_name'=>$user_name,
            'user_pwd'=>$user_pwd
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
        $data = json_decode($res,true);
        if($data['status']==1000){
            setcookie('token',$data['token'],time()+60*60*2,'/','shop.admin.com',0);
            setcookie('userInfo',json_encode($data['data']),time()+60*60*2,'/','shop.admin.com',0);
            return $res;
        }else{
            return $res;
        }
    }
    //登录执行
    public function loginDo(Request $request){
        $user_name = $request->post('user_name');
        $user_pwd = $request->post('user_pwd');
        //验证参数完整性
        if(empty($user_name)||empty($user_pwd)){
            return ['status'=>100,'msg'=>'参数不能为空'];die;
        }
        $where=[
            'user_name'=>$user_name
        ];
        //验证用户
        $userInfo = User::where($where)->first();
        if(empty($userInfo)){
            return ['status'=>101,'msg'=>'用户或密码不正确'];die;
        }
        $user_id = $userInfo->user_id;
        //验证此用户是否注册了商家
        $businessInfo = Business::where('user_id',$user_id)->first();
        if(empty($businessInfo)){
            return ['status'=>102,'msg'=>'您还不是商家'];die;
        }else{
            //将查到的结果处理成数组
            $businessInfo = collect($businessInfo)->toArray();
            //生成token
            $token = md5(json_encode($businessInfo).time());
            //查询用户有没有登陆过
            $tokenInfo = Token::where(['user_id'=>$businessInfo['user_id']])->first();
            //登录成功生成token
            if($tokenInfo){
                $res = Token::where('id',$tokenInfo->id)->update(['token'=>$token,'expire'=>time()+7200]);
            }else{
                $res = Token::insert(['token'=>$token,'user_id'=>$businessInfo['user_id'],'expire'=>time()+7200]);
            }
            //返回提示信息
            if($res){
                return ['status'=>1000,'token'=>$token,'data'=>$businessInfo];
            }else{
                return ['status'=>103,'msg'=>'登录失败'];
            }

        }
    }


    //退出登录接口
    public function quit(Request $request){
        $token = $request->post('token');
        $res = Token::where('token',$token)->delete();
        if($res!==false){
            return ['status'=>1000,'msg'=>'退出成功'];
        }else{
            return ['status'=>189,'msg'=>'退出失败'];
        }
    }

    //客户端退出登录
    public function quitLogin(){
        $token = $_COOKIE['token']??'';
        $userInfo = $_COOKIE['userInfo']??'';
        //登录接口地址
        $url='http://shop.admin.com/quit';
        $ch = curl_init();
        $data = [
            'token'=>$token
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
        //判断是否退出成功
        if($res['status']==1000){
            echo '<script>alert("退出成功");location.href="/login"</script>';
            //销毁token和信息
            setcookie('token','',time()-60,'/','shop.admin.com',0);
            setcookie('userInfo','',time()-60,'/','shop.admin.com',0);
        }else{
            echo '<script>alert("退出失败");location.href="/admin"</script>';
        }

    }
}
