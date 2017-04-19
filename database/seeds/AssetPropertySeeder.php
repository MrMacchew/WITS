<?php

use Illuminate\Database\Seeder;

class AssetPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Asset::class, 10)->create();
        factory(App\Properties::class, 10)->create();

        $asset = App\Asset::find(1);
        $asset->property()->attach(2);
        $asset->property()->attach(3);
        $asset->property()->attach(4);

        $property = App\Properties::find(5);
        $property->asset()->attach(6);
        $property->asset()->attach(7);
        $property->asset()->attach(8);

    }
}
