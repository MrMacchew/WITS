<?php

use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('building')->insert(['campus_id' => 1, 'name' => "Lampros Hall", 'latlong' => "{}", ]);
        DB::table('building')->insert(['campus_id' => 1, 'name' => "Wattis Business", 'latlong' => "{}", ]);
        DB::table('building')->insert(['campus_id' => 1, 'name' => "Elizabeth Hall", 'latlong' => "{}", ]);



    }
}
