<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatus extends Model
{
    protected $table = "complaints_status";

    /**
     * There are multiple Complaints in every Complaint Status
     * @return [collection] App::Complaint
     */
    public function complaints(){
        return $this->hasMany('App\Complaint');
    }

    static public function initialStatus(){
    	return 1; 
    }
}
