<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        if (App::environment() === 'production')
        {
            //Production Seeds
            // $this->call(UsersSeeder::class);

        }
        else
        {
            //Staging Seeds
            $this->call(UsersSeeder::class);
            $this->call(CampusSeeder::class);
            // $this->call(BuildingSeeder::class); //Campus adds data
            // $this->call(AssetSeeder::class);
        }

        //both production or test items

        //roles
        //properties
    }
}
