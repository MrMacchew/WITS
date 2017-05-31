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
        // factory(App\Department::class, 10)->create();

        // factory(App\Department::class, 50)->create();

        $department = App\Department::find(1);
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());

        $department = App\Department::find(2);
        $department->org()->save(factory(App\Org::class)->make());

        $department = App\Department::find(3);
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());


        $department = App\Department::find(4);
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());
        $department->org()->save(factory(App\Org::class)->make());


        DB::table('org')->insert([
            'name' => "Admin",
            'department_id' => 5,
            'code' => 25000
            ]);

        DB::table('org')->insert([
            'name' => "Botany",
            'department_id' => 5,
            'code' => 25100
            ]);

        DB::table('org')->insert([
            'name' => "Zoology",
            'department_id' => 5,
            'code' => 25700
            ]);

        DB::table('org')->insert([
            'name' => "Spares",
            'department_id' => 5,
            'code' => 25001
            ]);

    }
}
