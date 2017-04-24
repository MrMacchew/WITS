<?php

namespace Tests\Feature;

use App\Room;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_see_the_assets_page()
    {
        Passport::actingAs(factory(User::class)->create());
        $response = $this->get('/assets');
        $response->assertStatus(200);

    }

    /** @test */
    function it_can_post_an_asset()
    {
        $user = factory(User::class)->create();
        $room = factory(Room::class)->create();

        $data = [
        'name' => 'computer',
        'room_id' => $room->id
        ];

        $response = $this->actingAs($user)->json('POST', '/assets', $data);

        $response ->assertStatus(200);

        $this->assertJson($response->content());
        $this->assertArrayHasKey('name', $response->decodeResponseJson());

    }

    /** @test */
    function it_can_get_an_asset()
    {
        // dump(\App\Asset::find(1));
    }


}
