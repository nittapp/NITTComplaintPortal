<?php

use Faker\Generator as Faker;

use App\Complaint;
use App\ComplaintComment;
use App\User;

$factory->define(ComplaintComment::class, function (Faker $faker) {

	$complaintIDs = Complaint::pluck('id');

	$complaintID = $faker->randomElement($complaintIDs->toArray());
	$userID = ((Complaint::find($complaintID))->user)->id;
 
    return [
        "complaint_id" => $complaintID,
        "user_id" => $userID,
        "comment" => $faker->text,
    ];
});
