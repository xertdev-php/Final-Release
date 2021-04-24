<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\User::create(array(
           "username"=>"Super Admin",
            "last_name"=>"Admin",
            "first_name"=>"Super",
            "email"=>"superadmin@gmail.com",
            "password"=>"Admin123#"
        ));
    }
}
