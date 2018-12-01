<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budan extends Model
{
    protected $table = 'budan';
    protected $primaryKey = 'b_id';
   
    protected $fillable = [
    	'input_username','money','trade_no'
    ];
}
