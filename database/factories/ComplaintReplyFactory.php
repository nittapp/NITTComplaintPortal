<?php

use Faker\Generator as Faker;

use App\Complaint;
use App\ComplaintComment;
use App\ComplaintReply;
use App\User;

$factory->define(ComplaintReply::class, function (Faker $faker) {

	$parentIDs = ComplaintComment::pluck('id');
	$parentID = $faker->randomElement($parentIDs->toArray());

	$userID = ComplaintComment::find($parentID)->user_id;

    return [
        "parent_id" => $parentID,
        "user_id" => $userID,
        "comment" => $faker->text,
    ];
});
