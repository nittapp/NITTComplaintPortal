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
use App\Exceptions\AppCustomHttpException;

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


        catch (AppCustomHttpException $e){

            return response()->json([
                                    "message" => $e->getMessage(),
                                    ], $e->getCode());
        }

        catch (Exception $e){
            return response()->json([
                                    "message" => "Internal server error",
                                    ], 500);

        }
    }



    /**
    * Using the User ID from the session, title, description and image url as input parameters
    * this function creates a new complaint in the database
    * @param Request $request - title, description
    * @return json response 
    */
    public function createComplaints(Request $request){

      try  {
           $response = Complaint::validateRequest($request);
           $response = Complaint::createComplaints($request['title'],$request['description'], 
           $request['image_url']);
           return response()->json([
                                 "message" => "complaint sucessfully created"], 200);  
            } 

      catch (AppCustomHttpException $e) {

            return response()->json([
                                    "message" => $e->getMessage(),
                                    ], $e->getCode());
        }
      catch (Exception $e) {
            
            return response()->json([
                                    "message" => "Internal Server error",
                                    ], 500);
        }
     
      }


    /**
      * By using the data that is input for the edits to be made
      * changes are made for those fields that are changed
    */
    public function editComplaints(Request $request){
      try {
          $response = Complaint::validateRequest($request);
          $response = Complaint::editComplaints($request['complaint_id'],$request['title'],
                                                $request['description'],$request['image_url']);
          return response()->json([
                     "message" => "complaint sucessfully edited"
                     ], 200);  
      }

      catch (AppCustomHttpException $e){
        return response()->json([
                                "message" => $e->getMessage(),
                                 ],$e->getCode());

      }

      catch (Exception $e){
        return response()->json([
                                "message" => "Internal Server error"
                                 ],500);
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
        } 

        catch (AppCustomHttpException $e){

            return response()->json([
                                    "message" => $e->getMessage(),
                                    ], $e->getCode());
        }
        catch (Exception $e){
            
            return response()->json([
                                    "message" => "Internal server error",
                                    ], 500);
        }
    }


        /**
     * By using the ID of complaint given by user, the function deletes the * complaint, complaintComment and complaintStatus from the Complaint, 
     * ComplaintComment and ComplaintStatus tables respectively
     * @param $id
     * @return previous state, updated after deletion
     */

     public function deleteComplaints(Request $request){
 
       try{  
         $response = Complaint::deleteComplaint($request['id']);
         return response()->json([
                                 "message" => "complaint deleted",
                                 "data" => $response,
                                 ], 200);
       } 
       catch (AppCustomHttpException $e){
            return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());
        }
        catch (Exception $e) {
            return response()->json([
                                    "message" => "Internal Server error",
                                    ],500);
        }
    }

    /**
     * The admin can edit the complaint status of any complaint by using the 
     * complaint id and status
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editComplaintStatus(Request $request){
        try{
            $response = Complaint::editComplaintStatus($request['complaint_id'], $request['status_id']);
            return response()->json([
                                    "message" => "status updated successfully",
                                    "data" => $response,
                                    ], 200);            
        }
        catch (AppCustomHttpException $e){
            return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());
        }
        catch (Exception $e) {
            return response()->json([
                                    "message" => "Internal Server error",
                                    ],500);
        }
    }

}
