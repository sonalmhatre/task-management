<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Sam',
                'email' => 'demo@gmail.com',
                'password' => bcrypt('Admin@123'),
            ],[
                'name' => 'Jonh',
                'email' => 'jonh@gmail.com',
                'password' => bcrypt('Admin@123'),
            ],[
                'name' => 'Aman',
                'email' => 'aman@gmail.com',
                'password' => bcrypt('Admin@123'),
            ]
            ];
        DB::table('users')->insert($data);
    }
}
