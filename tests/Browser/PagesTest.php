<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PagesTest extends DuskTestCase
{
    /**
     * @test
     */
    public function homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('WITS');
        });
    }

    public function dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboard')
                    ->assertSee('dashboard');
        });
    }

    /**
     * @test
     */
    public function login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('WITS');
        });
    }



}
