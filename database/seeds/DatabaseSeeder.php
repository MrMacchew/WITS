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

        //PRODUCTION SEEDS
        //roles & properties
        $this->call(PermissionSeeder::class);


        if (App::environment('local', 'testing'))
        {
            //Staging Seeds

            // $this->call(UsersSeeder::class);
            // $this->call(CampusSeeder::class);
            // $this->call(DepartmentOrgSeeder::class);
            // $this->call(BuildingDepartmentSeeder::class);
            // $this->call(RoomStyleSeeder::class);
            // $this->call(SupportSeeder::class);
            // $this->call(RoomSoftwareSeeder::class);
            // $this->call(AssetPropertyNameSeeder::class);
            // $this->call(PropertiesSeeder::class);
            // $this->call(CategorySeeder::class);
            // $this->call(AssetSeeder::class);
            // $this->call(CheckoutSeeder::class);
            // $this->call(AssetPropertySeeder::class);
            // $this->call(MediaSeeder::class);

        }



    }
}
