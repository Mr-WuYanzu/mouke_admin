<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CurrCateModel;
/**
 *
 * class CommonController
 * @author   <[<email address>]>
 * @package  App\Http\Controllers\Common
 * @date 2019-08-10
 */
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

    /**
     * [成功时的响应信息]
     * @param  string  $msg  [description]
     * @param  integer $code [description]
     * @param  integer $skin [description]
     * @return [type]        [description]
     */
    public function json_success($msg='success',$code=1,$skin=6)
    {
    	return $this->_Output($msg,$code,$skin);
    }

    /**
     * [失败时的响应信息]
     * @param  string  $msg  [description]
     * @param  integer $code [description]
     * @param  integer $skin [description]
     * @return [type]        [description]
     */
    public function json_fail($msg='fail',$code=2,$skin=5)
    {
    	return $this->_Output($msg,$code,$skin);
    }

    /**
     * [返回json格式响应信息]
     * @param  [type] $msg  [description]
     * @param  [type] $code [description]
     * @param  [type] $skin [description]
     * @return [type]       [description]
     */
    public function _Output($msg,$code,$skin)
    {
    	$arr=[
            'font'=>$msg,
            'code'=>$code,
            'skin'=>$skin
        ];
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
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
