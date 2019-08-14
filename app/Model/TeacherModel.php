<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TeacherModel extends Model
{
    //
    protected $table='teacher';
    protected $primarykey='t_id';
    public $timestamps=false;
}
