<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ComplaintValidator;
use App\ComplaintStatus;
use App\Exceptions\AppCustomHttpException;
use Exception;
use Validator;
use Illuminate\Http\Request;



class Complaint extends Model
{
    protected $table = 'complaints';

    /**
     * All Complaints are assigned a status 
     * @return App::ComplaintStatus 
     */
    public function complaintStatus(){
        return $this->belongsTo('App\ComplaintStatus','status_id');
    }

    /**
     * Each Complaints are made by a User
     * @return App::User
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

        /**
     * Each Complaints are made by a User
     * @return App::User
     */
    public function complaintComments(){
        return $this->hasMany('App\ComplaintComment');
    }


    static public function validateRequest(Request $request){
        $validator = Validator::make($request->all(), [
                          'title' => 'required|alpha_num|max:255',
                          'description' => 'required|alpha_num|max:1023',
                          'image_url' => 'nullable|active_url'
                    ]);

        if ($validator->fails())
            throw new AppCustomHttpException($validator->errors()->first(), 422);
                 
    }


    /**
     * By using the params - userID, startDate and endDate, the complaints are retieved by the
     * available combinations of parameters of startDate & endDate.
     * @param  userID    
     * @param  startDate 
     * @param  endDate   
     * @return [array] complaints
     */
     static public function getUserComplaints($startDate, $endDate, $hostel = NULL){
 
        $userID = User::getUserID();
        if(! $userID)
             throw new AppCustomHttpException("user not logged in", 401);

        $complaints = Complaint::select('id','title','description','image_url','created_at')
                               ->where('user_id',$userID)
                               ->get();
        if(isset($startDate))
            $complaints = $complaints->where('created_at','>=',$startDate);
        if(isset($endDate))
            $complaints = $complaints->where('created_at','<=',$endDate);

        return $complaints->values()->all();
    }


     /**
     * This is for the admin GET route. 
     * By using the complaint->user, complaint->status, user->hostel relationships, 
     * the data for the admin's complaint-feed is retrieved.   
     * @param  startDate 
     * @param  endDate
     * @param  hostel
     * @param  status
     * @return [array] response 
     */
    static public function getAllComplaints($startDate, $endDate, $hostel, $status){
         
        $userID = User::getUserID();
        if(! $userID)
            throw new AppCustomHttpException("user not logged in", 401);

        if(! User::isUserAdmin())
            throw new AppCustomHttpException("user not admin", 403);
 
         $complaints = Complaint::select('id','user_id','title','description',
                                        'status_id','image_url','created_at')
                               ->get();

        foreach ($complaints as $complaint) {
            $complaint->status = $complaint->complaintStatus()->select('name','message')->first();
            $complaint->user = $complaint->user()->select('username','name','room_no','hostel_id',
                                                          'phone_contact','whatsapp_contact','email')
                                                 ->first();

            $complaint->user->hostel = $complaint->user->hostel()->value('name');
        }

        if(isset($startDate))
            $complaints = $complaints->where('created_at','>=',$startDate);
        if(isset($endDate))
            $complaints = $complaints->where('created_at','<=',$endDate);
        if(isset($status))
            $complaints = $complaints->filter(function($complaint) use($status){
                return $complaint->status->name == $status;
            });
        if(isset($hostel))
            $complaints = $complaints->filter(function($complaint) use($hostel){
                return $complaint->user->hostel == $hostel;
            });

        return $complaints->values()->all();
    }



    /**
     * This is for the user POST route. 
     * By using the complaint description, hostel name, user ID,
     * a new instance of the table is created
     *default status is referred from the ComplaintStatus model
     * @param title
     * @param  description
     * @param  image_url
     * @return 1 for sucessfully created and 0 if not
    */
    static public function createComplaints($title, $description,$image_url=null){
        $userID = User::getUserID();
         
        $complaintModel = new Complaint;
        $complaintModel->title = $title; 
        $complaintModel->description = $description; 
        $complaintModel->image_url = $image_url; 
        $complaintModel->status_id = ComplaintStatus::initialStatus();

        $user = User::find($userID);
        $response = $user->complaints()->save($complaintModel);


    }

    /**
    * This is the user PUT route
    * By using the update id, description,title and image url
    * we are update the instance of the complaint using the id given
    * @param id
    * @param title
    * @param description
    * @param image_url
    * @return 1 for sucessfully created and 0 if not
    */
    
    static public function editComplaints($ComplaintID,$title,$description,$image_url){

        $complaint = Complaint::find($ComplaintID);
        if(empty($complaint))
            throw new AppCustomHttpException("Complaint not found",404);
        

        if($complaint->user_id != User::getUserID() && ! User::isUserAdmin())
            throw new AppCustomHttpException("Action not allowed",403);
        

        $complaint->title = $title; 
        $complaint->description = $description;
        $complaint->image_url = $image_url;
        $complaint->save();

    }




    static public function editComplaintStatus($complaintID, $status_id) {
        if(! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $complaint = Complaint::find($complaintID);
        
        if(empty($complaint))
            throw new AppCustomHttpException("complaint not found", 404);
         
        $complaint->status_id = $status_id;
        $complaint->save();    
    }


}
