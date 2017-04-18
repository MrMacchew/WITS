<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_1_fake_department_checks_name() {
        $data = [
        "name" => "foo",
        ];
        $asset = factory(\App\Department::class)->create($data);
        // dd($asset);
        $this->assertTrue($asset->name == "foo");
    }

    /** @test */
    public function it_creates_1_fake_department_checks_phone() {
        $data = [
        "phone" => "foo",
        ];
        $asset = factory(\App\Department::class)->create($data);
        // dd($asset);
        $this->assertTrue($asset->phone == "foo");
    }
}
