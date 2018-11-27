<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    protected $table = 'permission';
    protected $primaryKey = 'ps_id';
   
    protected $fillable = [
    	'ps_name','ps_pid','ps_c','ps_a','ps_route','ps_level','desc'
    ];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
