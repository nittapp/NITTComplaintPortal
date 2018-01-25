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
use App\Status;
use App\Exceptions\AppCustomHttpException;

class ComplaintReplyController extends Controller
{
    public function getComplaintReply(Request $request){
        try{
            $response = ComplaintReply::getComplaintReply($request['complaint_comment_id']);
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

    public function createComplaintReply(Request $request){
        try{
            $response = ComplaintReply::validateRequest($request);
            $response = ComplaintReply::createComplaintReply($request['complaint_comment_id'],
                                                               $request['comment']);
            return response()->json([
                                    "message" => "reply created successfully"
                                    ], 200);    
        } 
        catch (AppCustomHttpException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
        catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function editComplaintReply(Request $request){
        try{
            $response = ComplaintReply::validateRequest($request);
            $response = ComplaintReply::editComplaintReply($request['complaint_reply_id'],
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

    public function deleteComplaintReply(Request $request){
        try{
            $response = ComplaintReply::deleteComplaintReply($request['complaint_reply_id']);

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