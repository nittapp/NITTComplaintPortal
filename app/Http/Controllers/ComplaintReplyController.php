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
    								], 200);
    	}
    	catch (Exception $e) {
    		if($e->getCode() == 2)
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 403);
    		if($e->getCode() == 3)	
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 500);	    	
    	}
    }

    public function createReplies(Request $request){
    	try {
    		$response = ComplaintReply::createComplaintReplies($request['complaint_comment_id'],
    														   $request['comment']);
    		return response()->json([
    								"message" => "reply created successfully"
    								], 200);	
    	} 
    	catch (Exception $e) {
    		if($e->getCode() == 2)
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 403);
    		if($e->getCode() == 3)	
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 500);	    	    		
    	}
    }

    public function editReplies(Request $request){
    	try {
    		$response = ComplaintReply::editComplaintReplies($request['complaint_reply_id'],
    														 $request['comment']);
     		return response()->json([
    								"message" => "reply updated successfully"
    								]);	   		
    	} 
    	catch (Exception $e) {
     		if($e->getCode() == 2)
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 403);
    		if($e->getCode() == 3)	
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 500);	     		
    	}
    }

    public function deleteReplies(Request $request){
    	try {
    		$response = ComplaintReply::deleteComplaintReplies($request['complaint_reply_id']);

     		return response()->json([
    								"message" => "reply deleted successfully"
    								], 200);	 
    	} 
    	catch (Exception $e) {
     		if($e->getCode() == 2)
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 403);
    		if($e->getCode() == 3)	
	    		return response()->json([
	    								"message" => $e->getMessage(),
	    								], 500);    		
    	}
    }
}
