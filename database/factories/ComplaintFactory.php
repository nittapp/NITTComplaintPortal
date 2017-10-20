<?php

use Faker\Generator as Faker;
use App\Complaint;
use App\User;
use App\ComplaintStatus;


$factory->define(Complaint::class, function (Faker $faker) {

	$userIDs = User::pluck('id');
    $complaintStatusIDs = ComplaintStatus::pluck('id');

    return [ 
        "user_id" => $faker->randomElement($userIDs->toArray()),
        "title" => $faker->sentence,
        "description" => $faker->paragraph,
        "status_id" => $faker->randomElement($complaintStatusIDs->toArray()),
        "image_url" => $faker->url,
    ];
});
