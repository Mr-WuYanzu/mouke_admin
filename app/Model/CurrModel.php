<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 课程模型类
 * class CurrModel
 * @author   <[<gaojianbo>]>
 * @package  App\Model
 * @date 2019-08-09
 */

class CurrModel extends Model
{
    //指定表名
    protected $table='curr';
    //指定主键
    protected $primarykey='curr_id';
    //关闭时间戳自动写入
    public $timestamps=false;
    //关联课程分类表
    public function cate()
    {
    	return $this->hasOne('App\Model\CurrCateModel','curr_cate_id','curr_cate_id');
    }
}
