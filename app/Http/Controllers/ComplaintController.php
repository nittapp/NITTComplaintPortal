<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use App\User;
use App\Hostel;
use App\AuthorizationLevel;

class ComplaintController extends Controller
{
   /**
    * By using the User ID from the session, this function fetches the complaints made
    * by the user in accordance with request parameters
    * @param  Request $request - start_date, end_date
    * @return [collection of complaints] 
    */
   public function getComplaints(Request $request){
   	$userID = User::getUserID();
   	$response = Complaint::getComplaints($userID, $request['start_date'], $request['end_date']);		
   	
   	if($response['message'] == "User not logged in") //cannot retieve for user who has not logged in
   		return response()->json($response,403);
   	if($response['message'] == "Complaints available") //successful retrieval based on params
   		return response()->json($response,200);
   	
   }


}
