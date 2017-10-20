<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintComment extends Model
{
    protected $table = "complaints_comments";

    public function complaint(){
    	return $this->belongsTo('App\Complaint');
    }

    public function user(){
    	return  $this->belongsTo('App\User');
    }
}
