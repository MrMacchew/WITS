<?php

use Illuminate\Database\Seeder;

class RoomStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_style')->insert(['name' => "classroom", ]);
        DB::table('room_style')->insert(['name' => "office", ]);
        DB::table('room_style')->insert(['name' => "hallway", ]);
    }
}
