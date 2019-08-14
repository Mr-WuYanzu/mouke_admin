<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CurrModel extends Model
{
    //
    protected $table='curr';
    protected $primarykey='curr_id';
    public $timestamps=false;
}
