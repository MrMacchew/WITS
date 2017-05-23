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
            'primary_contact' => "Bret Assistante",
            ]);

        DB::table('departments')->insert([
            'name' => "Another Division",
            'primary_orgcode_id' => null,
            'phone' => "555-2345",
            'email' => "someone@weber.edu",
            'primary_contact' => "someone",
            ]);

        DB::table('departments')->insert([
            'name' => "ATS",
            'primary_orgcode_id' => 2,
            'phone' => "555-1235",
            'email' => "shelly@weber.edu",
            'primary_contact' => "Shelly",
            ]);

        DB::table('departments')->insert([
            'name' => "CATS",
            'primary_orgcode_id' => 3,
            'phone' => "555-1236",
            'email' => "allan@weber.edu",
            'primary_contact' => "Allan",
            ]);

    }
}
