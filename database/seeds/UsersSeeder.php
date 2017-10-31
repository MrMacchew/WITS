<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function ($user) {

            $user->assignRole('user');
            
            $user->departments()->sync([rand(1, 5)]);

            //add department
            // $user->department
        });
    }
}
