<?php

use Illuminate\Database\Seeder;

class BuildingDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Building::class, 10)->create();
        factory(App\Department::class, 10)->create();

        $building = App\Building::find(1);
    	$building->department()->attach(2);
    	$building->department()->attach(3);
    	$building->department()->attach(4);


    	$department = App\Department::find(5);
        $department->building()->attach(6);
        $department->building()->attach(7);
        $department->building()->attach(8);

    }
}
