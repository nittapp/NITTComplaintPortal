<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
   protected $table = "complaints_status";

   static public function isViewable($statusID){
    return Status::where('id',$statusID)->value('is_viewable');
   }

   static public function isCreatable($statusID){
    return Status::where('id',$statusID)->value('is_creatable');
   }

   static public function isEditable($statusID){
    return Status::where('id',$statusID)->value('is_editable');
   }

   static public function isDeletable($statusID){
    return Status::where('id',$statusID)->value('is_deletable');
   }
}
