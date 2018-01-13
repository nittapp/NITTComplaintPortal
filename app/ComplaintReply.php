<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\AppCustomHttpException;

class ComplaintReply extends Model
{
    protected $table = "complaints_replies";

    /**
     * Each Comment Reply must belong to a comment thread
     * @return App::ComplaintComment
     */
    public function complaintComment(){
        return $this->belongsTo('App\ComplaintComment','parent_id');
    }

    /**
     * Each Comment Reply is made by a user
     * @return App::User
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function valdiateRequest(Request $request){
        $validator = Validator::make($request->all(), [
                    'complaint_comment_id' => 'integer|required',
                    'comment' => 'required',
                    ]);

        if ($validator->fails())
            throw new AppCustomHttpException($validator->errors()->first(), 500);

    }

    static public function getComplaintReplies($complaintCommentID){

       $complaintComment = ComplaintComment::find($complaintCommentID); 
       if(empty($complaintComment))
            throw new AppCustomHttpException("comment not found", 404);
            
        if($complaintComment->user_id != User::getUserID() &&
           ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $complaintReplies = $complaintComment->complaintReplies()->orderBy('created_at','desc')->get();

        return $complaintReplies->values()->all();
    }


    static public function createComplaintReplies($complaintCommentID, $comment){

        $complaintComment = ComplaintComment::find($complaintCommentID);
        if(empty($complaintComment))
            throw new AppCustomHttpException("comment not found", 404);
            
        if($complaintComment->user_id != User::getUserID() &&
           ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $complaintReplyModel = new ComplaintReply;
        $complaintReplyModel->user_id = User::getUserID();
        $complaintReplyModel->comment = $comment;
        $response = $complaintComment->complaintReplies()->save($complaintReplyModel);        
    }

    static public function editComplaintReplies($complaintReplyID, $comment){
        $complaintReply = ComplaintReply::find($complaintReplyID);
        if(empty($complaintReply))
            throw new AppCustomHttpException("reply not found", 404);

        if($complaintReply->user_id != User::getUserID() && ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $complaintReply->comment = $comment;
        $response = $complaintReply->save();
    }

    static public function deleteComplaintReplies($complaintReplyID){
        $complaintReply = ComplaintReply::find($complaintReplyID);
        if(empty($complaintReply))
            throw new AppCustomHttpException("reply not found", 404);

        if($complaintReply->user_id != User::getUserID() && ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $response = $complaintReply->delete();        
    }
}
