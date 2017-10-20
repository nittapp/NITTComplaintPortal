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
        // $this->call(UsersTableSeeder::class);
    	factory(App\Hostel::class, 10)->create();
    	factory(App\AuthorizationLevel::class, 3)->create();
    	factory(App\User::class, 5)->create();

    	factory(App\ComplaintStatus::class, 4)->create();
    	factory(App\Complaint::class, 20)->create();
        factory(App\ComplaintComment::class, 30)->create();
        factory(App\ComplaintReply::class, 10)->create();
    }
}
