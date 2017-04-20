<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CampusTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_a_campus()
    {
        $this->assertTrue(true);
    }


}
