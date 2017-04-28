<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class DashboardTest extends TestCase
{
	use DatabaseMigrations;
    /** @test */
    public function it_goes_to_dashboard_when_a_user_is_logged_in(){
    	$user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->get('/dashboard');
        $this->assertTrue($response->status() == 200);
    }

}
