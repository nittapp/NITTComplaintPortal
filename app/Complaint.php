<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    public function complaintStatus(){
    	return $this->belongsTo('App\ComplaintStatus');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
