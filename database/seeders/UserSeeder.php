<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user 
        DB::table("users")->insert([
            "fullname" => "super admin",
            "email" => "admin@email.com",
            "is_admin" => 1,
            "password" => Hash::make("admin12345")
        ]);


    }
}
