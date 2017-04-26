<?php

namespace Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @test
     */
    public function it_goes_to_login()
    {
        $response = $this->post('/login');
        $this->assertTrue($response->status() == 200);
    }


}
