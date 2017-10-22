<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    /**
     * All Complaints are assigned a status 
     * @return App::ComplaintStatus 
     */
    public function complaintStatus(){
    	return $this->belongsTo('App\ComplaintStatus');
    }

    /**
     * Each Complaints are made by a User
     * @return App::User
     */
    public function user(){
    	return $this->belongsTo('App\User');
    }

    /**
     * By using the params - userID, startDate and endDate, the complaints are retieved by the
     * available combinations of parameters of startDate & endDate.
     * @param  userID    
     * @param  startDate 
     * @param  endDate   
     * @return [array] response 
     */
    static public function getComplaints($userID, $startDate, $endDate){
        $response = [];
        if(!isset($userID)){
            $response['message'] = "User not logged in";
            return $response;
        }

        $complaints = Complaint::where('user_id',$userID)->get();
        if(isset($startDate))
            $complaints = $complaints->where('created_at','>=',$startDate);
        if(isset($endDate))
            $complaints = $complaints->where('created_at','<=',$endDate);


        $response['message'] = "Complaint available";
        $response['data'] = $complaints;
        return $response; 
    }
}
