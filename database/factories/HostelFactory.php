<?php

use Faker\Generator as Faker;
use App\Hostel;

$factory->define(Hostel::class, function (Faker $faker) {
    return [
        "name" => $faker->word,
    ];
});
