<?php

use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assets')->delete();
        factory(App\Asset::class, 50)->create();
    }
}
