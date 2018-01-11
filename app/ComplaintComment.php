<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

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
        $validator = Validator::make($request->all(), [
                    'complaint_id' => 'integer|required',
                    'comment' => 'required',
                    ]);

        if ($validator->fails())
            throw new Exception($validator->errors()->first(),  4);                 
    }

    /**
     * Each complaint has comments which are fetched only with complaintID
     * @param  [int] $complaintID 
     * @return  [collection] App::ComplaintComment
     */
    static public function getComplaintComments($complaintID){
        
        if(empty(Complaint::find($complaintID)))
            throw new Exception("Complaint not found", 3);

        if(empty(ComplaintComment::where('complaint_id',$complaintID)->first()))
            throw new Exception("comments not found", 3);
            
        if(Complaint::find($complaintID)->user()->value('id') != User::getUserID() &&
           ! User::isUserAdmin())
            throw new Exception("action not allowed", 2);

        $comments = ComplaintComment::where('complaint_id',$complaintID)
                                    ->orderBy('created_at')
                                    ->get();

        return $comments->values()->all();
            
    }

    static public function createComplaintComments($complaintID, $comment){
        if(empty(Complaint::find($complaintID)))
            throw new Exception("Complaint not found", 3);

        if(Complaint::find($complaintID)->user()->value('id') != User::getUserID() &&
           ! User::isUserAdmin())
            throw new Exception("action not allowed", 2);

        $complaintCommentModel = new ComplaintComment;
        $complaintCommentModel->user_id = User::getUserID();
        $complaintCommentModel->comment = $comment;

        $complaint = Complaint::find($complaintID);
        $response = $complaint->complaintComments()->save($complaintCommentModel);
    }

    static public function editComplaintComments($complaintCommentID, $comment){

        $complaintComment = ComplaintComment::find($complaintCommentID);
        if(empty($complaintComment))
            throw new Exception("Comment not found", 3);

        if($complaintComment->user_id != User::getUserID())
            throw new Exception("action not allowed", 2);
         
        $complaintComment->comment = $comment;
        $complaintComment->save();
    }

    static public function deleteComplaintComments($complaintCommentID){
        $complaintComment = ComplaintComment::find($complaintCommentID);
        if(empty($complaintComment))
            throw new Exception("Comment not found", 3);

        if($complaintComment->user_id != User::getUserID())
            throw new Exception("action not allowed", 2);
        $complaintComment->delete();   
    }
}
