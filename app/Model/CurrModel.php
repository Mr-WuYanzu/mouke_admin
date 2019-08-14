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
    //
    protected $table='curr';
    protected $primarykey='curr_id';
    public $timestamps=false;
}
