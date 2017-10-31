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
        // factory(App\Asset::class, 200)->create();

        factory(App\Asset::class, 200)->create()->each(function ($asset) {

            // $asset->assignRole('user');
            // $asset->departments()->sync([rand(1, 5)]);
            // dump($asset->toArray());
        	// dump($asset->properties->saveMany( factory( App\Properties::class, rand(2,4))->make() ));
        	$asset->properties()->saveMany(factory(App\Properties::class)->make());
        	// dump($asset->properties());
        });

    }
}
