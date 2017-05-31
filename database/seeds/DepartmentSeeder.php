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
        DB::table('departments')->insert([
            'name' => "IT",
            'primary_orgcode_id' => 1,
            'phone' => "555-1234",
            'email' => "bret-assistante@weber.edu",
            'primary_contact_name' => "Bret Assistante",
            'parent_department_id' => null,
            ]);

        DB::table('departments')->insert([
            'name' => "_Division",
            'primary_orgcode_id' => null,
            'phone' => "555-2345",
            'email' => "someone@weber.edu",
            'primary_contact_name' => "someone",
            'parent_department_id' => null,
            ]);

        DB::table('departments')->insert([
            'name' => "ATS",
            'primary_orgcode_id' => 2,
            'phone' => "555-1235",
            'email' => "shelly@weber.edu",
            'primary_contact_name' => "Shelly",
            'parent_department_id' => 1,
            ]);

        DB::table('departments')->insert([
            'name' => "CATS",
            'primary_orgcode_id' => 3,
            'phone' => "555-1236",
            'email' => "allan@weber.edu",
            'primary_contact_name' => "Allan",
            'parent_department_id' => 3,
            ]);
        DB::table('departments')->insert([
            'name' => "College of Science",
            // 'primary_orgcode_id' => 1,
            'phone' => "8016267061",
            'email' => "tylerhardy@weber.edu",
            'primary_contact_name' => "Tyler Hardy",
            'parent_department_id' => 3,
            ]);

    }
}
