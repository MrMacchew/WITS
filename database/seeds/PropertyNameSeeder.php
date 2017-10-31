<?php

use Illuminate\Database\Seeder;

class PropertyNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('property_name')->insert(['name' => "Mac Address Wired"]);
        DB::table('property_name')->insert(['name' => "Mac Address Wireless"]);

    }
}
