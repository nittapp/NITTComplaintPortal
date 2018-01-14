<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\AppCustomHttpException;

use Validator;
use Illuminate\Http\Request;

class ComplaintComment extends Model
{
    protected $table = "complaints_comments";

    /**
     * Each Comment Comment is a part of a Complaint
     * @return App::Complaint
     */
    public function complaint(){
        return $this->belongsTo('App\Complaint');
    }

    /**
     * Every Complaint Comment is made by a User
     * @return App::User
     */
    public function user(){
        return  $this->belongsTo('App\User');
    }


    public function complaintReplies(){
        return $this->hasMany('App\ComplaintReply','parent_id');
    }


    static public function validateRequest(Request $request){
        if($request->method() == 'POST')
            $validator = Validator::make($request->all(), [
                        'complaint_id' => 'integer|required',
                        'comment' => 'required|string',
                        ]);
        else
            $validator = Validator::make($request->all(), [
                        'complaint_comment_id' => 'integer|required',
                        'comment' => 'required|string',
                        ]);
        if ($validator->fails())
            throw new AppCustomHttpException($validator->errors()->first(), 422);
    }

    /**
     * Each complaint has comments which are fetched only with complaintID
     * @param  [int] $complaintID 
     * @return  [collection] App::ComplaintComment
     */
    static public function getComplaintComments($complaintID){
        
        if(empty(Complaint::find($complaintID)))
            throw new AppCustomHttpException("Complaint not found", 404);

        if(empty(ComplaintComment::where('complaint_id',$complaintID)->first()))
            throw new AppCustomHttpException("comments not found", 404);

        if(Complaint::find($complaintID)->user()->value('id') != User::getUserID() &&
           ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $comments = ComplaintComment::where('complaint_id',$complaintID)
                                    ->orderBy('created_at')
                                    ->get();

        return $comments->values()->all();

    }

    static public function createComplaintComments($complaintID, $comment){
        if(empty(Complaint::find($complaintID)))
            throw new AppCustomHttpException("Complaint not found", 404);

        if(Complaint::find($complaintID)->user()->value('id') != User::getUserID() &&
           ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);

        $complaintCommentModel = new ComplaintComment;
        $complaintCommentModel->user_id = User::getUserID();
        $complaintCommentModel->comment = $comment;

        $complaint = Complaint::find($complaintID);
        $response = $complaint->complaintComments()->save($complaintCommentModel);
    }

    static public function editComplaintComments($complaintCommentID, $comment){

        $complaintComment = ComplaintComment::find($complaintCommentID);
        if(empty($complaintComment))
            throw new AppCustomHttpException("Comment not found", 404);

        if($complaintComment->user_id != User::getUserID() && ! User::isUserAdmin())
            throw new AppCustomHttpException("action not allowed", 403);
         
        $complaintComment->comment = $comment;
        $complaintComment->save();
    }

    static public function deleteComplaintComments($complaintCommentID){
        $complaintComment = ComplaintComment::find($complaintCommentID);
        if(empty($complaintComment))
            throw new AppCustomHttpException("Comment not found", 404);

        if($complaintComment->user_id != User::getUserID() && ! User::isUserAdmin())
            throw new AppCustomHttpException("Action not allowed", 403);
        $complaintComment->delete();
    }
}
