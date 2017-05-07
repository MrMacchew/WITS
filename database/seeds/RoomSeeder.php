<?php

use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('room')->insert([
    		'building_id' => 1,
    		'number' => "203",
    		'style_id' => 1,
    		'name' => "roomname",
    		'latlong' => "{}",
    		]);

    }
}
