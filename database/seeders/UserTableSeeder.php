<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users= array(
            [
                "name"      => "Administrator",
                "username"  => "Admin",
                "email"     => "admin01@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 1
            ],
            [
                
                "name"      => "Kasir",
                "username"  => "kasir",
                "email"     => "kasir@gmail.com",
                "password"  => Hash::make(12345678),
                "role_id"   => 2
            ],
            
        );
        DB::table('users')->insert($users);
    }
}
