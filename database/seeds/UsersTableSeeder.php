<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 110,
                'name'           => 'api admin',
                'email'          => '3ps@developer.com',
                'password'       => bcrypt('daniel'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
