<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    public function hostel(){
        return $this->belongsTo('App\Hostel');
    }

    public function authorizationLevel(){
        return $this->belongsTo('App\AuthorizationLevel');
    }

    public function complaints(){
    	return $this->hasMany('App\Complaints');
    }

    public function complaintComments(){
    	return $this->hasMany('App\ComplaintComment');
    }

    public function complaintReplies(){
    	return $this->hasMany('App\ComplaintReply');
    }
}
