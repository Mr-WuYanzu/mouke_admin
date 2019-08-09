<?php

namespace App\Http\Controllers\Curr;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\CommonController;
use App\Model\CurrModel;
use App\Model\CurrChapterModel;
/**
 * 课程章节模块类
 * class CurrChapterController
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Controllers\Curr
 * @date 2019-08-09
 */
class CurrChapterController extends CommonController
{
	/**
	 * [添加课程章节页面]
	 * @param Request $request [description]
	 */
    public function add(Request $request)
    {
    	//实例化模型类
    	$currModel=new CurrModel();
    	//查询所有未下架课程信息
    	$currInfo=$currModel->where('status','!=',3)->get()->toArray();
    	//渲染视图
    	return view('currchapter/add',compact('currInfo'));
    }

    /**
     * [添加课程章节处理]
     * @param Request $request [description]
     */
    public function addHandle(Request $request)
    {
    	//接收表单数据
    	$data=$request->post('data');
    	//设置添加时间
    	$data['create_time']=time();
    	//实例化模型类
    	$currChapterModel=new CurrChapterModel();
    	//入库
    	$res=$currChapterModel->insert($data);
    	//判断结果,返回响应
    	if($res){
    		echo $this->json_success('添加成功');
    	}else{
    		echo $this->json_fail('添加失败');
    	}
    }

    /**
     * [课程章节列表]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function list(Request $request)
    {
    	//实例化模型类
    	$currChapterModel=new CurrChapterModel();
    	//查询所有课程章节信息
    	$chapterInfo=$currChapterModel->with('curr')->get()->toArray();
    	//渲染视图
    	return view('currchapter/list',compact('chapterInfo'));
    }

    /**
     * [修改课程章节页面]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function edit(Request $request)
    {
    	//接收章节id
    	$chapter_id=$request->get('chapter_id');
    	//实例化模型类
    	$currChapterModel=new CurrChapterModel();
    	$currModel=new CurrModel();
    	//查询章节信息
    	$chapterInfo=$currChapterModel->where('chapter_id',$chapter_id)->first();
    	if(empty($chapterInfo)){
    		$this->abort('章节信息有误,请重试','/currchapter/list');return;
    	}
    	$chapterInfo=$chapterInfo->toArray();
    	//实例化模型类
    	$currModel=new CurrModel();
    	//查询所有未下架课程信息
    	$currInfo=$currModel->where('status','!=',3)->get()->toArray();
    	//渲染视图
    	return view('currchapter/edit',compact('chapterInfo','currInfo'));
    }

    /**
     * [修改课程章节处理]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editHandle(Request $request)
    {
    	//接收表单数据
    	$data=$request->post('data');
    	//设置修改时间
    	$data['update_time']=time();
    	//实例化模型类
    	$currChapterModel=new CurrChapterModel();
    	//更新数据
    	$res=$currChapterModel->where('chapter_id',$data['chapter_id'])->update($data);
    	//检测结果,返回响应
    	if($res){
    		echo $this->json_success('修改成功');
    	}else{
    		echo $this->json_fail('修改失败');
    	}
    }

    /**
     * [删除课程章节]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function del(Request $request)
    {
    	//接收章节id
    	$chapter_id=$request->post('chapter_id');
    	//实例化模型类
    	$currChapterModel=new CurrChapterModel();
    	//删除数据
    	$res=$currChapterModel->where('chapter_id',$chapter_id)->delete();
    	//检测结果,返回响应
    	if($res){
    		echo $this->json_success('删除成功');
    	}else{
    		echo $this->json_fail('删除失败');
    	}
    }

    /**
     * [检测章节名称唯一性]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkChapterName(Request $request)
    {
    	//接收章节名称
    	$chapter_name=$request->post('chapter_name');
    	//接收章节id
    	$chapter_id=$request->post('chapter_id');
    	//实例化模型类
    	$currChapterModel=new CurrChapterModel();
    	//查询章节名称是否存在
    	if(empty($chapter_id)){
    		$count=$currChapterModel->where('chapter_name',$chapter_name)->count();
    	}else{
    		$count=$currChapterModel->where('chapter_name',$chapter_name)->where('chapter_id','!=',$chapter_id)->count();
    	}
    	//判断结果,返回响应
    	if($count>0){
    		echo $this->json_fail('章节名称已被占用');
    	}else{
    		echo $this->json_success();
    	}
    }
}
