<?php

use Faker\Generator as Faker;
use App\AuthorizationLevel;

$factory->define(AuthorizationLevel::class, function (Faker $faker) {
    return [
       "type" => str_random(8),
       "complaint_create_access" => $faker->randomElement($array = array (true, false)),
       "complaint_edit_access" => $faker->randomElement($array = array (true, false)),
       "complaint_delete_access" => $faker->randomElement($array = array (true, false)),
    ];
});
