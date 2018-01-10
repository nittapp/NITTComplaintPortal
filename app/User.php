<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    /**
     * each User belongs to one hostel
     * @return App::Hostel
     */
    public function hostel(){
        return $this->belongsTo('App\Hostel');
    }

    /**
     * Each User has a alloted Authorization level which allows - edit, create and delete access
     * to complaints
     * @return App::AuthorizationLevel
     */
    public function authorizationLevel(){
        return $this->belongsTo('App\AuthorizationLevel');
    }

    /**
     * Every User can register multiple complaints
     * @return [collection] App::Complaint
     */
    public function complaints(){
        return $this->hasMany('App\Complaints');
    }

    /**
     * Each User can have multiple Comments on his/her own complaints
     * @return [collection] App::ComplaintComment
     */
    public function complaintComments(){
        return $this->hasMany('App\ComplaintComment');
    }

    /**
     * Each User can have multiple replies on his/her own complaints
     * @return [collection] App::ComplaintReply
     */
    public function complaintReplies(){
        return $this->hasMany('App\ComplaintReply');
    }

    /**
     *  Retrieves the user_id from the session set. Right now using a dummy value
     *  @return [int] user_id
     */
    static public function getUserID(){
        return 5;
    }

    static public function isUserAdmin(){
        return false;
    }
}
