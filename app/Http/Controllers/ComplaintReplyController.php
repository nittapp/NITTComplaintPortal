<?php

namespace App\Http\Controllers;

use App\ComplaintReply;
use Illuminate\Http\Request;
use Exception;

class ComplaintReplyController extends Controller
{
    public function getReplies(Request $request){
    	try{
    		$response = ComplaintReply::getComplaintReplies($request['complaint_comment_id']);
    		return response()->json([
    								"message" => "replies available",
    								"data" => $response
    								],200);
    	}
    	catch (Exception $e) {
    		if($e->getCode() == 2)
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								],403);
    		if($e->getCode() == 3)	
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								],500);	    	
    	}
    }

    public function createComments(Request $request){

    }

    public function editComments(Request $request){

    }

    public function deleteComments(Request $request){

    }
}
