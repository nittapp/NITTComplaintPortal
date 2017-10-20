<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $table = "hostels";

    public function users(){
    	return $this->hasMany('App\User');
    }
}
