<?php

namespace App\Http\Controllers;
use App\ComplaintComment;

use Illuminate\Http\Request;

use Exception;

class ComplaintCommentController extends Controller
{
    public function getComments(Request $request){
    	try{
    		$response = ComplaintComment::getComplaintComments($request['complaint_id']);
    		return response()->json([
    								"message" => "comments available",
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
    	try {
    		$response = ComplaintComment::createComplaintComments($request['complaint_id'],
    															  $request['comment']);

    		return response()->json([
    								"message" => "comment created successfully"
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

    public function editComments(Request $request){
    	try{
    		$response = ComplaintComment::editComplaintComments($request['complaint_comment_id'],
    															$request['comment']
    															);
    		return response()->json([
    								"message" => "comment updated successfully"
    								],200);    		
    	}
    	catch(Exception $e){
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
}
