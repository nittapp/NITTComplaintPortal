<?php

use Faker\Generator as Faker;
use App\ComplaintStatus;

$factory->define(ComplaintStatus::class, function (Faker $faker) {
    return [
        "name" => $faker->word,
        "message" => $faker->text(20),
    ];
});
