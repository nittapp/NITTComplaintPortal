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
        DB::table('complaints_status')->insert(array(
             array('name'=>'submitted','message'=>'Your complaint has been submitted','is_viewable'=>true, 'is_editable'=>true, 'is_creatable'=>true, 'is_deletable'=>true),
             array('name'=>'in progress','message'=>'Your complaint is in progress','is_viewable'=>true, 'is_editable'=>false, 'is_creatable'=>false, 'is_deletable'=>false),
             array('name'=>'completed','message'=>'Your complaint has been completed','is_viewable'=>true, 'is_editable'=>false, 'is_creatable'=>false, 'is_deletable'=>false))); 
   
        /*Submitted, In progress, completed*/
    }
}
