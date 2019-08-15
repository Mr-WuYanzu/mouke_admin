<?php

namespace App\Http\Controllers\Curr;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\CommonController;
use App\Model\CurrModel;
/**
 * 课程模块类
 * class CurrController
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Controller\Curr
 * @date 2019-08-15
 */
class CurrController extends CommonController
{
	/**
	 * [课程评判页面]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function judge(Request $request)
    {
    	//实例化模型类
    	$currModel=new CurrModel();
    	//查询所有通过审核并上架的课程信息
    	$currInfo=$currModel->where('curr_status',1)->where('is_show',1)->get();
    	//渲染视图
    	return view('curr/judge',compact('currInfo'));
    }

    public function judgeDo(Request $request)
    {
    	//接收评判课程信息
    	$data=$request->post('data');
    	//实例化模型类
    	$currModel=new CurrModel();
    	//更新数据
    	$res=$currModel->where('curr_id',$data['curr_id'])->update($data);
    	//检测结果,返回提示
    	if($res){
    		$this->json_success('评判成功');
    	}else{
    		$this->json_fail('评判失败');
    	}
    }
}
