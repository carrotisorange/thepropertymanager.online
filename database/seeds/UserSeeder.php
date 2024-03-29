<?php

use Illuminate\Database\Seeder;

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
            'name' => 'Arleen Fatton',
            'email' => 'marthaleasing@yahoo.com',
            'password' => Hash::make('12345678'),
            'status' => 'registered',
            'role_id_foreign' => 1,
            'property' => 'The Courtyards'
        ]);

        DB::table('users')->insert([
            'name' => 'Anand Perez',
            'email' => 'marthaoyonc@gmail.com',
            'password' => Hash::make('12345678'),
            'status' => 'registered',
            'user_type' => 1,
            'property' => 'North Cambridge'
        ]);

        DB::table('users')->insert([
            'name' => 'Shane Gonzales',
            'email' => 'marthagoshenland@yahoo.com',
            'password' => Hash::make('12345678'),
            'status' => 'registered',
            'user_type' => 3,
            'property' => 'The Courtyards'
        ]);

        DB::table('users')->insert([
            'name' => 'Aldrin Magno',
            'email' => 'aldrinqm12@gmail.com',
            'password' => Hash::make('12345678'),
            'status' => 'registered',
            'user_type' => 5,
            'property' => 'The Courtyards'
        ]);


    }
}
