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
        DB::table('division_department_teams')->insert(['name' => "IT"]);
        DB::table('division_department_teams')->insert(['name' => "Another"]);

    }
}
