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

        if($userID){
            $response = Complaint::getComplaints($userID, $request['start_date'], $request['end_date']);
            return response()->json([
                                        "message" => "complaints available",
                                        "data" => $response,
                                    ], 200);
        }

        return response()->json([
                                    "message" => "user not logged in",
                                    "data" => "unavailable",
                                ], 403);
   }

}
