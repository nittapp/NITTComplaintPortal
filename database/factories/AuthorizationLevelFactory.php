<?php

use Faker\Generator as Faker;
use App\AuthorizationLevel;

$factory->define(AuthorizationLevel::class, function (Faker $faker) {
    return [
       "type" => "student",
       "complaint_create_access" => true,
       "complaint_edit_access" => true,
       "complaint_delete_access" => true,
    ];
});
