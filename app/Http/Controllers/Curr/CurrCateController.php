<?php

namespace App\Http\Controllers\Curr;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\CommonController;
use App\Model\CurrCateModel;
/**
 * 课程分类模块类
 * class CurrCateController
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Controllers\Curr
 * @date 2019-08-09
 */
class CurrCateController extends CommonController
{
	/**
	 * [课程分类添加页面]
	 * @param Request $request [description]
	 */
    public function add(Request $request)
    {
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//查询所有分类信息
    	$cate=$currCateModel->where('status',1)->get()->toArray();
    	//获取递归分类信息
    	$cateInfo=$this->getCateInfo($cate);
    	//渲染视图
    	return view('currcate/add',compact('cateInfo'));
    }

    /**
     * [课程分类添加处理]
     * @param Request $request [description]
     */
    public function addHandle(Request $request)
    {
    	//接收表单数据
    	$data=$request->post('data');
    	//设置添加时间
    	$data['create_time']=time();
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//入库
    	$res=$currCateModel->insert($data);
    	//检测结果,返回响应
    	if($res){
    		echo $this->json_success('添加成功');
    	}else{
    		echo $this->json_fail('添加失败');
    	}
    }

    /**
     * [课程分类列表]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function list(Request $request)
    {
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//查询所有分类信息
    	$cate=$currCateModel->where('status',1)->get()->toArray();
    	//获取递归分类信息
    	$cateInfo=$this->getCateInfo($cate);
    	//渲染视图
    	return view('currcate/list',compact('cateInfo'));
    }

    /**
     * [修改课程分类页面]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function edit(Request $request)
    {
    	//获取分类id
    	$curr_cate_id=$request->post('curr_cate_id');
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//查询分类信息
    	$cate_row=$currCateModel->where('status',1)->where('curr_cate_id',$curr_cate_id)->first();
    	//检测该分类是否存在
    	if(empty($cate_row)){
    	   $this->abort('分类信息有误,请重试','/currcate/list');return;
    	}
    	$cate_row=$cate_row->toArray();
    	//查询所有分类信息
    	$cate=$currCateModel->where('status',1)->get()->toArray();
    	//获取递归分类信息
    	$cateInfo=$this->getCateInfo($cate);
    	//渲染视图
    	return view('currcate/edit',compact('cate_row','cateInfo'));
    }

    /**
     * [修改课程分类处理]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editHandle(Request $request)
    {
    	//获取修改数据
    	$data=$request->post('data');
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//查询当前分类的子分类
    	$pid=$currCateModel->where('curr_cate_id',$data['curr_cate_id'])->value('pid');
    	//查询当前分类下是否有子分类
    	$count=$currCateModel->where('pid',$data['curr_cate_id'])->count();
    	//如果当前分类下有子分类不能修改为子分类
    	if($count>0 && $pid!=$data['pid']){
    		echo $this->json_fail('该分类下存在子分类,不可修改');return;
    	}
    	//设置修改时间
    	$data['update_time']=time();
    	//更新数据
    	$res=$currCateModel->where('curr_cate_id',$data['curr_cate_id'])->update($data);
    	//判断结果,返回响应
    	if($res){
    		echo $this->json_success('修改成功');
    	}else{
    		echo $this->json_fail('修改失败');
    	}
    }

    /**
     * [分类名称即点即改]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editCateName(Request $request)
    {
        //接收分类id
        $curr_cate_id=$request->post('curr_cate_id');
        //接收分类名称
        $cate_name=$request->post('cate_name');
        //实例化模型类
        $currCateModel=new CurrCateModel();
        //验证分类名称唯一性
        $count=$currCateModel->where('cate_name',$cate_name)->where('curr_cate_id','!=',$curr_cate_id)->count();
        //如果存在返回提示
        if($count>0){
            echo $this->json_fail('分类名称已被占用');return;
        }
        //更新数据
        $res=$currCateModel->where('curr_cate_id',$curr_cate_id)->update(['cate_name'=>$cate_name]);
        //判断结果,返回提示
        if($res){
            echo $this->json_success('修改成功');
        }else{
            echo $this->json_fail('修改失败');
        }
    }

    /**
     * [删除课程分类]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function del(Request $request)
    {
    	//接收分类id
    	$curr_cate_id=$request->post('curr_cate_id');
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//检测当前分类下是否存在子分类
    	$count=$currCateModel->where('pid',$curr_cate_id)->count();
    	//如果有,不可以删除
    	if($count>0){
    		echo $this->json_fail('该分类下存在子分类,不可删除');return;
    	}
    	//软删除数据
    	$res=$currCateModel->where('curr_cate_id',$curr_cate_id)->update(['status'=>2]);
    	//判断结果,返回响应
    	if($res){
    		echo $this->json_success('删除成功');
    	}else{
    		echo $this->json_fail('删除失败');
    	}
    }

    /**
     * [验证分类名称唯一性]
     * @param  [type] $cate_name [description]
     * @return [type]            [description]
     */
    public function checkCateName(Request $request)
    {
    	//接收分类名称
    	$cate_name=$request->post('cate_name');
    	//接收分类id
    	$cate_id=$request->post('curr_cate_id');
    	//实例化模型类
    	$currCateModel=new CurrCateModel();
    	//查询分类名称是否存在
    	if(empty($cate_id)){
    		$count=$currCateModel->where('cate_name',$cate_name)->count();
    	}else{
    		$count=$currCateModel->where('cate_name',$cate_name)->where('curr_cate_id','!=',$cate_id)->count();
    	}
    	//检测结果,返回响应
    	if($count>0){
    		echo $this->json_fail('分类名称已被占用');
    	}else{
    		echo $this->json_success();
    	}
    }
}
