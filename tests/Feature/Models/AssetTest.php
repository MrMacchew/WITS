<?php

namespace Tests\Feature\Models;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Artisan;
use Eloquent;


class AssetTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_1_fake_assets_checks_name() {
        $data = [
        "name" => "roomname"
        ];
        $asset = factory(\App\Asset::class)->create($data);

        $this->assertTrue($asset->name == "roomname");
    }


     /** @test */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
