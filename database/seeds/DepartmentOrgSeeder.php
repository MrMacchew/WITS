<?php

use Illuminate\Database\Seeder;

class DepartmentOrgSeeder extends Seeder
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
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());

        $department = App\Department::find(2);
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());


    }
}