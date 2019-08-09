<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * 课程章节模型类
 * class CurrChapterModel
 * @author   <[<gaojianbo>]>
 * @package  App\Model
 * @date 2019-08-09
 */
class CurrChapterModel extends Model
{
    //指定表名
    public $table='curr_chapter';
    //指定主键
    public $primaryKey='chapter_id';
    //关闭时间戳
    public $timestamps=false;
    //关联课程表
    public function curr()
    {
    	return $this->belongsTo('App\Model\CurrModel','curr_id','curr_id');
    }
}
