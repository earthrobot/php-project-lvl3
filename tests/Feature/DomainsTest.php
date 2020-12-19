<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    protected $id;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('domains')->insert([
            'name' => 'domain.ru',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
            ]
        );
        $this->id = DB::table('domains')->where('name', 'domain.ru')->value('id');
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

    public function testDomain()
    {
        $response = $this->get(route('domain', ['id' => $this->id]));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testAddDomain()
    {
        $response = $this->post(route('domains.store'), ['domain.name' => 'https://newdomain.ru']);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domains', ['name' => 'newdomain.ru']);
    }
}
