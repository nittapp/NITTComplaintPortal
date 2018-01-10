<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class ComplaintReply extends Model
{
    protected $table = "complaints_replies";

    /**
     * Each Comment Reply must belong to a comment thread
     * @return App::ComplaintComment
     */
    public function comment(){
        return $this->belongsTo('App\ComplaintComment');
    }

    /**
     * Each Comment Reply is made by a user
     * @return App::User
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    static public function getComplaintReplies($complaintCommentID){
       if(empty(ComplaintComment::find($complaintCommentID)))
            throw new Exception("comment not found", 3);
            
        if(ComplaintComment::find($complaintCommentID)->user_id != User::getUserID() &&
           ! User::isUserAdmin())
            throw new Exception("action not allowed", 2);

        $commentReplies = ComplaintReply::where('parent_id',$complaintCommentID)
                                    ->orderBy('created_at')
                                    ->get();

        return $commentReplies->values()->all();
    }
}
