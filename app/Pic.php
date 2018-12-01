<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pic extends Model
{
    protected $table = 'pic';
    protected $primaryKey = 'pic_id';
   
    protected $fillable = [
    	'picture','updated_time','deleted_time','created_time'
    ];


 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
