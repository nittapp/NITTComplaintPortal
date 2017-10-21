<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    /**
     * All Complaints are assigned a status 
     * @return App::ComplaintStatus 
     */
    public function complaintStatus(){
    	return $this->belongsTo('App\ComplaintStatus');
    }

    /**
     * Each Complaints are made by a User
     * @return App::User
     */
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
