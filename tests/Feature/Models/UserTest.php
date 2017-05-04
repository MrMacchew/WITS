<?php

namespace Tests\Feature\Models;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Artisan;
use Eloquent;
use Spatie\Permission\Models\Role;


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


    /** @test */
    public function it_uses_request_all_params(){
        //Arrange
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $demoUser = \App\User::create([
                "first_name" => "demo",
                "last_name" => "user",
                "username" => "demouser",
                "email" => "demo@weber.edu",
                "password" => bcrypt('demodemo')
                ])->assignRole('user');

        $adminUser = \App\User::create([
                "first_name" => "admin",
                "last_name" => "user",
                "username" => "adminuser",
                "email" => "admin@weber.edu",
                "password" => bcrypt('adminadmin')
                ])->assignRole('admin');

        $this->assertEquals(2, \App\User::all()->count());

        // //Act
        $response = $this->get('/api/v1/users?search=demo&with=roles,departments&fields=email,id,username');

        // //Assert
        $this->assertTrue($response->status() == 200);
        $response->assertJsonFragment(['username' => 'demouser']);

        $data = (array) $response->decodeResponseJson()['data'];

        $this->assertEquals(1, count($data));
        $this->assertNotEquals(2, count($data));

        //has Keys
        $this->assertTrue(array_key_exists("roles",$data[0]));
        $this->assertTrue(array_key_exists("departments",$data[0]));
    }

    /** @test */
    public function it_can_request_with(){

        //Arrange
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $demoUser = \App\User::create([
                "first_name" => "demo",
                "last_name" => "user",
                "username" => "demouser",
                "email" => "demo@weber.edu",
                "password" => bcrypt('demodemo')
                ]);
        $demoUser->assignRole('user');

        $adminUser = \App\User::create([
                "first_name" => "admin",
                "last_name" => "user",
                "username" => "adminuser",
                "email" => "admin@weber.edu",
                "password" => bcrypt('adminadmin')
                ]);
        $adminUser->assignRole('admin');

        $this->assertEquals(2, \App\User::all()->count());

        // //Act
        $response = $this->get('/api/v1/users?with=roles,departments');

        // //Assert
        $this->assertTrue($response->status() == 200);

        $data = (array) $response->decodeResponseJson()['data'];

        $this->assertEquals(2, count($data));

        // //has Keys
        $this->assertTrue(array_key_exists("roles",$data[0]));
        $this->assertTrue(array_key_exists("departments",$data[0]));

        // //role has user
        // $this->assertTrue("user" === $keys['roles'][0]['name']);

    }



     /** @test */
    public function it_can_request_search(){
        $response = $this->get('/api/v1/users?search=de');
        $this->assertTrue($response->status() == 200);
    }



    /** @test */
    public function it_can_request_fields(){
        $response = $this->get('/api/v1/users?fields=id,email');
        $this->assertTrue($response->status() == 200);
    }


    /** @test */
    public function it_grabs_the_first_user(){
         //Arrange
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $demoUser = \App\User::create([
                "first_name" => "demo",
                "last_name" => "user",
                "username" => "demouser",
                "email" => "demo@weber.edu",
                "password" => bcrypt('demodemo')
                ])->assignRole('user');
        $adminUser = \App\User::create([
                "first_name" => "admin",
                "last_name" => "user",
                "username" => "adminuser",
                "email" => "admin@weber.edu",
                "password" => bcrypt('adminadmin')
                ])->assignRole('admin');

        $this->assertEquals(2, \App\User::all()->count());

        //Act
        $response = $this->get('/api/v1/users/1');

        //Assert
        $this->assertTrue($response->status() == 200);

        $data = (array) $response->decodeResponseJson();
        // dd($data);

        //has Keys
        $this->assertTrue(array_key_exists("first_name",$data));
        $this->assertTrue(array_key_exists("username",$data));
    }

    /** @test */
    public function it_grabs_the_first_user_with_withs(){
         //Arrange
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $demoUser = \App\User::create([
                "first_name" => "demo",
                "last_name" => "user",
                "username" => "demouser",
                "email" => "demo@weber.edu",
                "password" => bcrypt('demodemo')
                ])->assignRole('user');

        $adminUser = \App\User::create([
                "first_name" => "admin",
                "last_name" => "user",
                "username" => "adminuser",
                "email" => "admin@weber.edu",
                "password" => bcrypt('adminadmin')
                ])->assignRole('admin');

        $this->assertEquals(2, \App\User::all()->count());

        //Act
        $response = $this->get('/api/v1/users/1?with=roles,departments');

        //Assert

        //page loads
        $this->assertTrue($response->status() == 200);

        $data = (array) $response->decodeResponseJson();
        // dd($data);

        //has Keys
        $this->assertTrue(array_key_exists("roles",$data));
        $this->assertTrue(array_key_exists("departments",$data));

        //role == user
        $this->assertEquals('user',$data['roles'][0]['name']);

    }


}
