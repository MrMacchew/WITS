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
    public function it_creates_at_least_ten_fake_campus() {
        $campus = factory(\App\Campus::class, mt_rand(10, 20))->create();
        $campus_count = count($campus) >= 10;

        $this->assertTrue($campus_count);
    }


}
