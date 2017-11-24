<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizationLevel extends Model
{
    protected $table = "authorization_levels";

    /**
     * Every authorization level has many users assigned to it
     * @return [collection] App::User
     */
    public function users(){
        return $this->hasMany('App\Users');
    }
}
