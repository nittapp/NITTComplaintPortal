<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintReply extends Model
{
    protected $table = "complaints_replies";

    /**
     * Each Comment Reply must belong to a comment thread
     * @return App::ComplaintComment
     */
    public function comment(){
    	return $this->belongsTo('App\ComplaintComment');
    }

    /**
     * Each Comment Reply is made by a user
     * @return App::User
     */
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
