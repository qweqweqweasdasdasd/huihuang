<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $table = 'manager';
    protected $primaryKey = 'mg_id';
    protected $rememberTokenName = '';

    protected $fillable = [
    	'mg_name','password','session_id','r_id','last_login_time','desc'
    ];


 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //一对多(逆向)
    public function role()
    {
    	return $this->belongsTo('App\Role','r_id','r_id');
    }
}
 