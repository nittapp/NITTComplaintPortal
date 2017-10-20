<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatus extends Model
{
    protected $table = "complaints_status";

    public function complaints(){
    	return $this->hasMany('App\Complaint');
    }
}
