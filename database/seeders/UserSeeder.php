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
        DB::table('users')->insert(
            [
                [
                    'name' => 'user',
                    'email' => 'user@user.com',
                    'role' => 'user',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'role' => 'admin',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'super_admin',
                    'email' => 'super_admin@super_admin.com',
                    'role' => 'super_admin',
                    'password' => '$12$HXP16/YWH56G7FYXNLtRa.sn2P1O4okv2nXzSl7B2VdGhW.wbaPzK', //pasword
                ]
            ]

        );

        // DB::table('users')->insert([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'role' => 'admin',
        //     'password' => bcrypt('password'),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'super_admin',
        //     'email' => 'super_admin@super_admin.com',
        //     'role' => 'super_admin',
        //     'password' => bcrypt('password'),
        // ]);
    }
}
