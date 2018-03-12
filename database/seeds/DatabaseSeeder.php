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
         * Calling the seeds in the following order ensures that foreign key 
         * constraints are not violated
         */
        factory(App\Hostel::class, 1)->create();  //add 10 hostels
        factory(App\AuthorizationLevel::class, 1)->create(); //add 3 auth levels
        factory(App\ComplaintStatus::class, 1)->create(); //add 3 auth levels
    }
}
