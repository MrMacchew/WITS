<?php

use Illuminate\Database\Seeder;

class OrgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Org::class, 10)->create();
    }
}
