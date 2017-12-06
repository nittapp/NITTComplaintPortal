<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use App\User;
use App\Hostel;
use App\AuthorizationLevel;
use App\ComplaintComment;
use App\ComplaintReply;
use App\ComplaintStatus;

use Exception;

class DeleteController extends Controller 
{
    /**
     * By using the ID of complaint given by user, the function deletes the * complaint, complaintComment and complaintStatus from the Complaint, 
     * ComplaintComment and ComplaintStatus tables respectively
     * @param $id
     * @return previous state, updated after deletion
     */

   public function deleteComplaint(Request $request){
 
      try{  
         $response = Complaint::deleteComplaint($userID, $request['id']);
         return response()->json([
                                 "message" => "complaint deleted",
                                 "data" => $response,
                                 ], 200);
      } catch (Exception $e) {
           if ($e->getCode() == 1)
               return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 401);
           if ($e->getCode() == 2)
               return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 403);   
      
           if ($e->getCode() == 3)
               return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 404);  
      }
   }
}

class ComplaintController extends Controller
{
    /**
     * By using the User ID from the session, this function fetches the complaints made
     * by the user in accordance with request parameters
     * @param  Request $request - start_date, end_date
     * @return [collection of complaints]
     */
    public function getUserComplaints(Request $request) {
        try {
            $response = Complaint::getUserComplaints($request['start_date'], $request['end_date']);
            return response()->json([
                                    "message" => "complaints available",
                                    "data" => $response,
                                    ], 200);
        }
        catch (Exception $e){
            if($e->getCode() == 1)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 401);
        }
    }
    
    /**
    * By using the session data, the user is checked for logged in and admin.
    * If both are true, then all the complaints are retrieved for the admin for the 
    * sake of populating the admin feed.
    * @param  Request $request 
    * @return [json]           
    */
    public function getAllComplaints(Request $request) {
        try {
            $response = Complaint::getAllComplaints($request['start_date'], $request['end_date'], $request['hostel'], $request['status']);
            return response()->json([
                                    "message" => "complaints available",
                                    "data" => $response,
                                    ], 200);
        } catch (Exception $e) {
            if ($e->getCode() == 1)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 401);
            if ($e->getCode() == 2)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 403);
        }
    }

}
