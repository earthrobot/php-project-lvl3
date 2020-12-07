<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DomainsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testHome()
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }

    public function testDomains()
    {
        $response = $this->get(route('domains'));
        $response->assertOk();
    }

    public function testAddDomain()
    {
        DB::table('domains')->insert([
            'name' => 'domain.ru',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
            ]
        );
        
        $this->assertDatabaseHas('domains', 1);
    }

    public function testAddedDomain()
    {
        DB::table('domains')->insert([
            'name' => 'domain.ru',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
            ]
        );
        $response = $this->get(route('domain', 1));
        $response->assertOk();
    }
}
