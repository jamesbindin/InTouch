<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'Username' => 'user1',
            'Firstname' => 'Aiden',
            'Surname' => 'Knight',
            'DateOfBirth' => '1955/3/3',
            'PhoneNumber' => '3766047050',
            'Email' => 'aiden.knight@example.com'
        ]);
        DB::table('users')->insert([
            'Username' => 'user2',
            'Firstname' => 'Annette',
            'Surname' => 'Gutierrez',
            'DateOfBirth' => '1960/11/2',
            'PhoneNumber' => '0571550625',
            'Email' => 'annette.gutierrez@example.com'
        ]);
        DB::table('users')->insert([
            'Username' => 'user3',
            'Firstname' => 'Bryan',
            'Surname' => 'Castro',
            'DateOfBirth' => '1948/6/2',
            'PhoneNumber' => '8696893324',
            'Email' => 'bryan.castro@example.com'
        ]);
        DB::table('users')->insert([
            'Username' => 'user4',
            'Firstname' => 'Allison',
            'Surname' => 'Gilbert',
            'DateOfBirth' => '1985/10/3',
            'PhoneNumber' => '1266408856',
            'Email' => 'allison.gilbert@example.com'
        ]);

    }
}
