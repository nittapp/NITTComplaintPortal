<?php

use Faker\Generator as Faker;
use App\ComplaintStatus;

$factory->define(ComplaintStatus::class, function (Faker $faker) {
    return [
        "name" => "complaint submitted",
        "message" => "complaint in progress",
    ];
});
