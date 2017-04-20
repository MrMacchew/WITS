<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Campus extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    public function test_index()
    {
       // $user = factory(\App\User::class)->create();
       // $this->actingAs($user, 'api');

        $response = $this->json('GET', '/api/v1/campus');
        $response->assertSee('[]');
        // ->assertStatus(200);
    }

    public function test_store()
    {
        // $user = factory(\App\User::class)->create();
        // $this->actingAs($user, 'api');

        $response = $this->json('POST', '/api/v1/campus', ['name' => 'foo', 'campus_code' => 123]);
        $response
            ->assertStatus(200)
            ->assertJson(['name' => 'foo', 'campus_code' => 123]);
    }
}
