<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CurrCateModel;

class CommonController extends Controller
{
	/**
	 * [跳转页面]
	 * @param  [type] $msg [description]
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
    public function abort($msg,$url)
    {
    	echo "<script>alert('{$msg}');location.href='{$url}';</script>";
    }

    public function json_success($msg='success',$code=1,$skin=6)
    {
    	return $this->_Output($msg,$code,$skin);
    }

    public function json_fail($msg='fail',$code=2,$skin=5)
    {
    	return $this->_Output($msg,$code,$skin);
    }

    public function _Output($msg,$code,$skin)
    {
    	$arr=[
    		'msg'=>$msg,
    		'code'=>$code,
    		'skin'=>$skin
    	];
    	return json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

    /**
     * [递归处理分类信息]
     * @param  [type]  $cateInfo [description]
     * @param  integer $pid      [description]
     * @param  integer $level    [description]
     * @return [type]            [description]
     */
    public function getCateInfo($cateInfo,$pid=0,$level=0)
    {
    	static $arr=[];
    	foreach ($cateInfo as $v) {
    		if($v['pid']==$pid){
    			$v['level']=$level;
    			$arr[]=$v;
    			$this->getCateInfo($cateInfo,$v['curr_cate_id'],$level+1);
    		}
    	}
    	return $arr;
    }

    public function showCateInfo($cateInfo,$pid=0,$level=0)
    {
    	$arr=[];
    	foreach ($cateInfo as $v) {
    		if($v['pid']==$pid){
    			$son=$this->showCateInfo($cateInfo,$v['curr_cate_id'],$level+1);
    			$v['son']=$son;
    			$arr[]=$v;
    		}
    	}
    	return $arr;
    }
}
