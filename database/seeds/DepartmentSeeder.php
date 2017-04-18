<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('department')->delete();
        // factory(App\Department::class, 10)->create();

        factory(App\Department::class, 10)->create();

        $department = App\Department::find(1);
        $department->org()->save(factory(App\Org::class)->make());


    }
}
