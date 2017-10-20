<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizationLevel extends Model
{
    protected $table = "authorization_levels";

    public function users(){
    	return $this->hasMany('App\Users');
    }
}
