<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name'=> 'ayman',
            'email'=>'ayman@ayman.com',
            'password'=>bcrypt('123123')
        ]);
        //
        User::create([
            'name'=> 'ahmed',
            'email'=>'ahmed@ahmed.com',
            'password'=>bcrypt('123123')
        ]);
        User::create([
            'name'=> 'khalid',
            'email'=>'khalid@khalid.com',
            'password'=>bcrypt('123123')
        ]);
    }
}
