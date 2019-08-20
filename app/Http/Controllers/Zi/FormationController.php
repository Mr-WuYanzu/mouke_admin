<?php

namespace App\Http\Controllers\Zi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class FormationController extends Controller
{
    #资讯列表
    public function list(){
        #查询资讯表的数据
        $res=DB::table('infomation')->get();
        $res=json_decode($res,true);
        foreach ($res as $k=>$v){
            #根据 咨询表的分类id 查询 分类表 的分类名称
            $info=DB::table('information_cate')->where(['info_cate_id'=>$v['info_cate_id']])->first();
            $res[$k]['info_name']=$info->info_name;
        }
        return view('information.list',compact('res'));
    }

    #分类资讯列表
    public function cate_list(){
        #查询资讯分类表的数据
        $res=DB::table('information_cate')->get();
        return view('information.cate_list',compact('res'));
    }

    #分类删除
    public function cate_del(Request $request){
        $res=DB::table('information_cate')->where(['info_cate_id'=>$request->info_cate_id])->delete();
        if($res){
            return ['code'=>1,'msg'=>'删除成功'];
        }else{
            return ['code'=>5,'msg'=>'删除失败--》请稍后重试'];
        }
    }

    #分类添加执行
    public function cate_do(Request $request){
        $c_name=$request->c_name;
        if(empty($c_name)){
            return ['code'=>2,'msg'=>'请输入分类名称'];
        }
        $arr=[
            'info_name'=>$c_name,
            'create_time'=>time()
        ];
        $res=DB::table('information_cate')->insert($arr);
        if($res){
            return ['code'=>1,'msg'=>'分类名称添加成功'];
        }else{
            return ['code'=>5,'msg'=>'分类名称添加失败'];
        }
    }

    #资讯添加页面
    public function add(){
        #查询分类表中的数据
        $res=DB::table('information_cate')->get();
        return view('information.add',compact('res'));
    }

    #资讯添加执行
    public function add_do(Request $request){
        $data=$request->post();
        #将数据添加入库
        $arr=[
            'info_title'=>$data['info_title'],
            'info_desc'=>$data['info_desc'],
            'info_detail'=>$data['info_detail'],
            'info_cate_id'=>$data['c_id'],
            'create_time'=>time()
        ];
        $res=DB::table('infomation')->insert($arr);
        if($res){
            return ['code'=>1,'msg'=>'添加资讯成功'];
        }else{
            return ['code'=>5,'msg'=>'添加资讯失败'];
        }

    }

    #资讯删除
    public function del(Request $request){
        $info_id=$request->info_id;
        $res=DB::table('infomation')->where(['info_id'=>$info_id])->delete();
        if($res){
            return ['code'=>1,'msg'=>'删除成功'];
        }else{
            return ['code'=>5,'msg'=>'删除失败'];
        }
    }
    #资讯修改
    public function update($id){
        if(empty($id)){
            echo "<script>alert('请选择修改的数据');location.href='/formation/list';</script>";exit;
        }
        #根据id查询到当前数据
        $info=DB::table('infomation')->where(['info_id'=>$id])->first();
        #分类数据
        $res=DB::table('information_cate')->get();
        return view('information.edit',compact('info','res'));
    }
    #修改执行
    public function edit(Request $request){
        $info_id=$request->info_id;
        $data=$request->all();
        unset($data['info_id']);
        $data['update_time']=time();
        $edit=DB::table('infomation')->where(['info_id'=>$info_id])->update($data);
        if($edit){
            echo "<script>alert('修改成功');location.href='/formation/list';</script>";exit;
        }else{
            echo "<script>alert('修改失败');location.href='/formation/list';</script>";exit;
        }
    }




}
