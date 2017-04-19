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
    	factory(App\AssetPropertyName::class, 2)->create();

    	$faker = Faker::create();

    	DB::table('properties') ->insert(['name_id' => 1, 'value' => $faker->unique(true)->macAddress()]);
    	DB::table('properties')->insert(['name_id' => 2, 'value' => $faker->unique(true)->macAddress()]);
    }
}
