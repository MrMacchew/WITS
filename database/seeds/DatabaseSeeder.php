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
            $this->call('ProductionSeeder');
            // $this->call(UsersTableSeeder::class);

        }
        else
        {
            //Staging Seeds
            $this->call('StagingSeeder');
        }
    }
}
