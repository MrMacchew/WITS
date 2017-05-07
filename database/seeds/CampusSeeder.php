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
        DB::table('campus')->insert(['name' => "WSU", "campus_code"=>'1']);
        DB::table('campus')->insert(['name' => "Davis", "campus_code"=>'2']);

    }
}
