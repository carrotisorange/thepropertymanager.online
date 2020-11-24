<?php

use Illuminate\Database\Seeder;

class OwnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i<=5; $i++ ) {
            DB::table('unit_owners')->insert([
                'unit_owner' => 'Juan',
                'investment_price' => '1000',
                'investment_type' => 'VIP'
            ]);
            }
    }
}
