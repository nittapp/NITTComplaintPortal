<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Exceptions\AppCustomHttpException;
use Validator;
use Exception;
use Illuminate\Http\Request;

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
    static public function getUserID(){
        return 1;
    }

    static public function isUserAdmin(){
        return true;
    }

    static public function primaryAuthId(){
        return 1; 
    }

    static public function adminAuthId(){
        return 2;
    }

   /////////HOSTEL ID FORMAT
    static public function validateRequest(Request $request){
        $validator = Validator::make($request->all(), [
                    'username' => 'required|alpha_num',
                    'name' => 'string|max:255',
                    'hostel_id' => 'required|string|max:6',
                    'phone_contact' => 'required|digits:10',
                    'whatsapp_contact' => 'required|digits:10',
                    'email' => 'required|email',
                    'room_no' => 'numeric',


                    ]);

        if ($validator->fails())
            throw new AppCustomHttpException($validator->errors()->first(), 422);
    }

    static public function createUser($name,$username,$room_no,$hostel_id,
        $phone_contact,$whatsapp_contact,$email,$fcm_id){

        if(!empty(User::find($username)) || !empty(User::find($phone_contact)))
            throw new AppHttpCustomException("User already exists",403); //////CHECK THE ERROR CODE
     
        $userModel = new User; 
        $userModel->name = $name; 
        $userModel->username = $username; 
        $userModel->room_no = $room_no; 
        $userModel->hostel_id = $hostel_id; 
        $userModel->phone_contact = $phone_contact; 
        $userModel->whatsapp_contact = $whatsapp_contact; 
        $userModel->fcm_id = $fcm_id;
        $userModel->email = $email; 
        $userModel->auth_user_id = User::primaryAuthId(); 
        $userModel->save();

    }

    static public function getUser($userID){

        if(empty(User::find($userID)))
            throw new AppCustomHttpException("User does not exist",404);

        if( $userID != User::getUserID() && !User::isUserAdmin() )
            throw new AppCustomHttpException("Action not allowed",403);

        $userDetails = User::where('id',$userID)->get(); 

        return $userDetails->values();

    }

    static public function editUser($user_id,$name,$phone_contact,$whatsapp_contact,$email,$hostel_id,$room_no){

        $user = User::find($user_id);
        if(empty($user))
            throw new AppCustomHttpException("User does not exist",404);

        if( $user_id != User::getUserID() && !User::isUserAdmin())
            throw new AppCustomHttpException("Action not allowed",403);

        $user->name = $name; 
        $user->room_no = $room_no; 
        $user->hostel_id = $hostel_id; 
        $user->phone_contact = $phone_contact; 
        $user->whatsapp_contact = $whatsapp_contact; 
        $user->email = $email; 
        $user->save();


    

    }

    static public function changeUserAuthId($userID){

        if(!User::isUserAdmin())
            throw new AppCustomHttpException("Action not allowed",403);
        $user = User::find($userID);
        $user->auth_user_id = User::adminAuthId();
        $user->save();

    }



    static public function deleteUser($userID){

        $user = User::find($userID);
        if(empty($user))
            throw new AppCustomHttpException("User does not exist",404);

        if( $userID != User::getUserID() && !User::isUserAdmin())
            throw new AppCustomHttpException("Action not allowed",403);
        $user->delete();


    }

}

