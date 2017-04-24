<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_post_a_room()
    {
        $roomstyle = factory(\App\RoomStyle::class)->create();
        $support = factory(\App\Support::class)->create();


        $data = [
        'style_id' => $roomstyle->id,
        'support_id' => $support->id,
        'number' => '100',
        'name' => 'roomname',
        'capacity' => 10,
        ];

        $response = $this->json('POST', '/room', $data);
        $response ->assertStatus(200);
        $this->assertJson($response->content());

    }

}
