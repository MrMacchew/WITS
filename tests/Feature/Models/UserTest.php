<?php

namespace Tests\Feature\Models;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Artisan;
use Eloquent;


class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_at_least_ten_fake_users() {
        $users = factory(\App\User::class, mt_rand(10, 20))->create();
        $user_count = count($users) >= 10;
        $this->assertTrue($user_count);
    }

    /** @test */
    public function it_creates_a_demo_user(){

            $user = \App\User::create([
                "first_name" => "demo",
                "last_name" => "user",
                "username" => "demouser",
                "email" => "demo@weber.edu",
                "password" => bcrypt('demodemo')
                ]);

            $demouser = \App\User::where('username','demouser')->first();
            $this->assertTrue($demouser->username == $user->username);
    }



}
