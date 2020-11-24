<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('units')->insert([
            'unit_no' => '204',
            'floor_no' => '2',
            'type_of_units' => 'residential',
            'unit_property' => 'The Courtyards',
            'building' => 'Loft',
            'beds' => '1',
            'monthly_rent' => '13000',
            'status' => 'vacant',
        ]);
       
    }
}
