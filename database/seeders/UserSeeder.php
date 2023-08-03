<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use carbon\carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Faker = Faker::create();
        $now = Carbon::now();

        DB::table('users')->insert([
            'firstName' => $Faker->firstName,
            'lastName' => $Faker->lastName,
            'email' => $Faker->email,
            'password' => Hash::make(1),
            'role' => "admin",
            'status' => 1,
            'phone' => '9876543210',
            'created_at' => $now,
            'updated_at' => $now,

        ]);
    }
}
