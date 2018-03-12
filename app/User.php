<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Exceptions\AppCustomHttpException;
use Validator;
use Exception;
use Illuminate\Http\Request;
use App\Hostel;
use App\AuthorizationLevel;
use App\Complaint;
use App\ComplaintComment;
use App\ComplaintReply;

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
        return $this->hasMany('App\Complaint');
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
    static public function getUserID($request){
       $user = User::where('username',$request->header('X-NITT-APP-USERNAME'))->first();
       return $user->id;
    }

    static public function isUserAdmin($request){
        return $request->header('X-NITT-APP-IS-ADMIN') == 'true';
    }

    static public function primaryAuthId(){
        return 1; 
    }

    static public function adminAuthId(){
        return 2;
    }

    static public function create($rollno){
        $user = new User();
        $user->username = $rollno;
        $user->save();
    }
}

