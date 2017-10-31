<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\PropertyName::class, 2)->create();
    }
}
