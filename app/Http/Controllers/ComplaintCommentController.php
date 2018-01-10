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
    	catch (Exception $e){
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
