<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use App\User;
use App\Hostel;
use App\AuthorizationLevel;

class ComplaintController extends Controller
{
   public function GetComplaints(Request $request){
	$complaintIDs = Complaint::pluck('id');
	$complaintID = array_rand($complaintIDs->toArray(), 1);
	//return $complaintID;
	$userID = ((Complaint::find($complaintID))->user)->id;
   	return $userID;
   }


}
