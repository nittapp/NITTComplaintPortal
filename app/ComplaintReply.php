<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintReply extends Model
{
    protected $table = "complaints_replies";

    public function comment(){
    	return $this->belongsTo('App\ComplaintComment');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
