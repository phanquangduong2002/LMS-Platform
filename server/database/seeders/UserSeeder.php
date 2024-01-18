<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            [
                "username" => "admin",
                "user_image" => "avatar.img",
                "name" => "Quang Dương",
                "email" => "quangduongsayhi@gmail.com",
                "password" => Hash::make("12345"),
                "roles" => "admin",
            ],
            [
                "username" => "bachduong",
                "user_image" => "avatar.img",
                "name" => "Bạch Dương",
                "email" => "bachduong@gmail.com",
                "password" => Hash::make("12345"),
                "roles" => "instructor",
            ],
            [
                "username" => "quangduong",
                "user_image" => "avatar.img",
                "name" => "Quang Dương",
                "email" => "quangduong@gmail.com",
                "password" => Hash::make("12345"),
                "roles" => "user",
            ]
        ]);
    }
}
