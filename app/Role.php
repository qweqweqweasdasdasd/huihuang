<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'r_id';
   
    protected $fillable = [
    	'r_name','ps_ids','ps_ca','desc'
    ];


 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //一对多的关系
    public function managers()
    {
    	return $this->hasMany('App\Manager','r_id','r_id');
    }
}
