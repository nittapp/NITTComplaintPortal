<?php

namespace App\Http\Controllers;

use App\ComplaintReply;
use Illuminate\Http\Request;

use App\Exceptions\AppCustomHttpException;
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
        catch (AppCustomHttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
        catch (Exception $e) {
            return response()->json(["message" => "Internal Server Error"], 500);
        }
    }

    public function createReplies(Request $request){
        try {
            $response = ComplaintReply::validateRequest(Request $request);
            $response = ComplaintReply::createComplaintReplies($request['complaint_comment_id'],
                                                               $request['comment']);
            return response()->json([
                                    "message" => "reply created successfully"
                                    ], 200);    
        } 
        catch (AppCustomHttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
        catch (Exception $e) {
            return response()->json(["message" => "Internal Server Error"], 500);
        }
    }

    public function editReplies(Request $request){
        try {
            $response = ComplaintReply::validateRequest(Request $request);
            $response = ComplaintReply::editComplaintReplies($request['complaint_reply_id'],
                                                             $request['comment']);
            return response()->json([
                                    "message" => "reply updated successfully"
                                    ]);         
        } 
        catch (AppCustomHttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
        catch (Exception $e) {
            return response()->json(["message" => "Internal Server Error"], 500);
        }
    }

    public function deleteReplies(Request $request){
        try {
            $response = ComplaintReply::deleteComplaintReplies($request['complaint_reply_id']);

            return response()->json([
                                    "message" => "reply deleted successfully"
                                    ], 200);     
        } 
        catch (AppCustomHttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
        catch (Exception $e) {
            return response()->json(["message" => "Internal Server Error"], 500);
        }
    }
}
