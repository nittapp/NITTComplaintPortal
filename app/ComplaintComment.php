<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintComment extends Model
{
    protected $table = "complaints_comments";

    /**
     * Each Comment Comment is a part of a Complaint
     * @return App::Complaint
     */
    public function complaint(){
    	return $this->belongsTo('App\Complaint');
    }

    /**
     * Every Complaint Comment is made by a User
     * @return App::User
     */
    public function user(){
    	return  $this->belongsTo('App\User');
    }
}
