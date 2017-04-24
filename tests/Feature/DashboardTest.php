<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardTest extends TestCase
{
    /** @test */
    public function it_goes_to_dashboard_when_a_user_is_logged_in(){
        $response = $this->get('/dashboard');
        $this->assertTrue($response->status() == 200);
    }

}
