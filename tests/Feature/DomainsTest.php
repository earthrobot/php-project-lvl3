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
use Illuminate\Support\Facades\Http;

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
        $this->name = 'https://domain.ru';
        DB::table('domains')->insert([
            'name' => $this->name,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
            ]
        );
        $this->id = DB::table('domains')->where('name', $this->name)->value('id');
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
        $response = $this->post(route('domains.store'), ['domain' => ['name' => 'https://newdomain.ru']]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domains', ['name' => 'https://newdomain.ru']);
    }

    public function testAddDomainCheck()
    {
        $body = '<html><head><meta name="keywords" content="keywords"><meta name="description" content="description"></head><body><h1>Page title</h1></body></html>';
        Http::fake(fn($request) => Http::response($body, 200));
        $response = $this->post(route('domains.check', ['id' => $this->id]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domain_checks', ['domain_id' => $this->id]);
    }
}
