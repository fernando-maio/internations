<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            ['name' => 'Master'],
            ['name' => 'Admin'],
            ['name' => 'User']
        ];

        DB::table('profiles')->insert($profiles);


        $masterUser = [
            'name' => 'Fernando Maio',
            'email' => 'maio.fernando@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Inter@2019'),
            'id_profile' => 1,
        ];

        DB::table('users')->insert($masterUser);
    }
}
