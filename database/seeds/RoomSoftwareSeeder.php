<?php

use Illuminate\Database\Seeder;

class RoomSoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Software::class, 10)->create();
        factory(App\Room::class, 10)->create();

        $software = App\Software::find(1);
    	$software->room()->attach(2);
    	$software->room()->attach(3);
    	$software->room()->attach(4);


    	$room = App\Room::find(5);
        $room->software()->attach(6);
        $room->software()->attach(7);
        $room->software()->attach(8);

    }
}
