<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        *Calling the seeds in the following order ensures that foreign key 
        *constraints are not violated
        */
    	factory(App\Hostel::class, 10)->create();  //add 10 hostels
    	factory(App\AuthorizationLevel::class, 3)->create(); //add 3 auth levels
    	factory(App\User::class, 5)->create(); //add 5 users

    	factory(App\ComplaintStatus::class, 4)->create(); //add 4 types of complaint statuses
    	factory(App\Complaint::class, 20)->create(); //add 20 complaints
        factory(App\ComplaintComment::class, 30)->create(); //add 30 complaint comments
        factory(App\ComplaintReply::class, 10)->create(); //add 10 complaint replies
    }
}
