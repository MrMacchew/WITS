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
        factory(App\RoomStyle::class, 15)->create();
    }
}
