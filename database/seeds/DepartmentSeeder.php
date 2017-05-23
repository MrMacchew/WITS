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
        DB::table('division_department_teams')->insert([
            'name' => "IT",
            'primary_orgcode_id' => 1,
            'phone' => "555-1234",
            'email' => "bret-assistante@weber.edu",
            'primary_contact' => "Bret Assistante",
            ]);
        DB::table('hierarchy')->insert([
            "division_id" => 1,
            "department_id" => null,
            "team_id" => null]
            );





        DB::table('division_department_teams')->insert([
            'name' => "Another Division",
            'primary_orgcode_id' => null,
            'phone' => "555-2345",
            'email' => "someone@weber.edu",
            'primary_contact' => "someone",
            ]);
        DB::table('hierarchy')->insert([
            "division_id" => 2,
            "department_id" => null,
            "team_id" => null]
            );



        DB::table('division_department_teams')->insert([
            'name' => "ATS",
            'primary_orgcode_id' => 2,
            'phone' => "555-1235",
            'email' => "shelly@weber.edu",
            'primary_contact' => "Shelly",
            ]);
        DB::table('hierarchy')->insert([
            "division_id" => 1,
            "department_id" => 2,
            "team_id" => null]
            );


        DB::table('division_department_teams')->insert([
            'name' => "CATS",
            'primary_orgcode_id' => 3,
            'phone' => "555-1236",
            'email' => "allan@weber.edu",
            'primary_contact' => "Allan",
            ]);
        DB::table('hierarchy')->insert([
            "division_id" => 1,
            "department_id" => 2,
            "team_id" => 4]
            );

    }
}
