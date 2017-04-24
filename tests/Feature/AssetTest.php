<?php

namespace Tests\Feature;

use App\Room;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AssetTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_see_the_assets_page()
    {
        // $this->disableExceptionHandling();
        // Passport::actingAs(factory(User::class)->create());
        $response = $this->get('/assets');
        $response->assertStatus(200);

    }

    /** @test */
    public function it_can_post_an_asset()
    {
        // $this->disableExceptionHandling();
        $user = factory(User::class)->create();
        $room = factory(Room::class)->create();


        $data = [
        'name' => 'computer',
        'room_id' => $room->id,
        ];

        $response = $this->json('POST', '/assets', $data);
        $response ->assertStatus(200);
        $this->assertJson($response->content());
    }

    /** @test */
    public function room_is_required_to_add_an_asset(){

        //Arrange
        $user = factory(User::class)->create();

        //Act
        $data = [
        'name' => 'computer',
        ];

        //Assert
        $response = $this->json('POST', '/assets', $data);

        $response->assertStatus(422);
        $this->assertArrayHasKey('room_id', $response->decodeResponseJson());

    }




}
