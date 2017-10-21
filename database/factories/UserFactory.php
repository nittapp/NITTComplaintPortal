<?php


use App\AuthorizationLevel;
use App\Hostel;
use App\User;

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;
    
    $hostelIDs = Hostel::pluck('id');
    $authorizationLevelIDs = AuthorizationLevel::pluck('id');

    return [
        'username' => str_random(10),
        'name' => $faker->name,
        'room_no' => $faker->randomDigit,
        'auth_user_id' => $faker->randomElement($authorizationLevelIDs->toArray()),
        'hostel_id' => $faker->randomElement($hostelIDs->toArray()),
        'phone_contact' => $faker->regexify('[0-9]{10}'),
        'whatsapp_contact' => $faker->regexify('[0-9]{10}'),
        'email' => $faker->unique()->safeEmail,
        'fcm_id' => str_random(10),
    ];
});
