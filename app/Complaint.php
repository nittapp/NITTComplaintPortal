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
     * By using the params - user_id, start_date(SD) and end_date(ED), the complaints are retieved by the
     * available combinations of parameters like SD is given and ED is not / SD and ED are both given.
     * It is supposed to fail if session is not set.
     * @param  userID    
     * @param  startDate 
     * @param  endDate   
     * @return [array] response 
     */
    static public function getComplaint($userID, $startDate, $endDate){
        $response = [];
        if(!isset($userID)){
            $response['message'] = "User not logged in, please login";
            return $response;
        }
        if(isset($startDate) || isset($endDate)){

            if(!isset($endDate))
                $complaint = Complaint::where('user_id',$userID)->where('created_at','>=',$startDate)->get();
            else if(!isset($startDate))
                $complaint = Complaint::where('user_id',$userID)->where('created_at','<=',$endDate)->get();
            else
                $complaint = Complaint::where('user_id',$userID)->where('created_at','>=',$startDate)
                                                                ->where('created_at','<=',$endDate)
                                                                ->get();

            $response['message'] = "Complaints found the user with the given dates";
            $response['data'] = $complaint;
            return $response;                                             
        }

        $complaint = Complaint::where('user_id',$userID)->get();

        $response['message'] = "All Complaints registered by the user";
        $response['data'] = $complaint;
        return $response; 
    }
}
