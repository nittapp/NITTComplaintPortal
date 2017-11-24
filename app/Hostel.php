<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $table = "hostels";

    /**
     * Every Hostel has multiple users in it
     * @return [collection] App::User
     */
    public function users(){
        return $this->hasMany('App\User');
    }
}
