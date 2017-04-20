<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * @test
     */
    public function it_goes_to_login()
    {
        $response = $this->get('/login');
        // dd($response->status());
        // dd($response->status() == 200||$response->status() == 302);
        $this->assertTrue($response->status() == 200||$response->status() == 302);
    }


}
