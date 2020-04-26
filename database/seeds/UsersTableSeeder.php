<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pawel = factory(\App\User::class)->create([
            'id' => 1,
            'name' => 'Pawel Bak',
            'email' => 'pawelbak300589@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $emilia = factory(\App\User::class)->create([
            'id' => 2,
            'name' => 'Emilia Mlak',
            'email' => 'emiliamlak@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $pawel->assignRole('SuperAdmin');
        $emilia->assignRole('Admin');
    }
}
