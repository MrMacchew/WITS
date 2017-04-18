<?php

use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Campus::class, 10)->create()->each(function ($campus) {

            $campus->buildings()->save(factory(App\Building::class)->make());
            // dump($campus);
        });
    }
}
