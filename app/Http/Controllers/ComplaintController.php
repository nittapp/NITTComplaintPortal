<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use App\User;
use App\Hostel;
use App\AuthorizationLevel;

use Exception;

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
                                        ], 403);
        }
    }
    /**
    * Using the User ID from the session, title, description and image url as input parameters
    * this function creates a new complaint in the database
    * @param Request $request - title, description
    * @return json response 
    */
    public function createComplaint(Request $request){

      try{

          if($userID){
             $response = Complaint::createComplaints(User::getUserID(),$request['title'],$request['description'], 
             $request['image_url']);
             return response()->json([
                     "message" => "complaints sucessfully created",
                     "data" => $response,
                     ], 200);  
            } 

         } catch (Exception $e) {
            //For bad arguments
              if ($e->getCode() == 1)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 160);
              if ($e->getCode() == 2)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 160);

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
            $response = Complaint::getAllComplaints($request['start_date'], $request['end_date'],
                                                    $request['hostel'], $request['status']);
            return response()->json([
                                    "message" => "complaints available",
                                    "data" => $response,
                                    ], 200);
        } catch (Exception $e) {
            if ($e->getCode() == 1)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 403);
            if ($e->getCode() == 2)
                return response()->json([
                                        "message" => $e->getMessage(),
                                        ], 401);
        }

    }

}
