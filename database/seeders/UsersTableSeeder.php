<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create multiple users
        DB::table('users')->insert([
            [
                'username' => 'user1@gmail.com',
                'password' => bcrypt('asd123456'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'user2@gmail.com',
                'password' => bcrypt('asd123456'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'user3@gmail.com',
                'password' => bcrypt('asd123456'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
