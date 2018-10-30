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
       //$users = factory(App\User::class, 1000)->create();
    	//$users = factory(App\Organization::class, 100)->create();
    	$users = factory(App\Profile::class, 5000)->create();
    }
}
