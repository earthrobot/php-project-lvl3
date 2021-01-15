<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DomainsTest extends TestCase
{
    /**
     * A basic feature test.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = DB::table('domains')->insertGetId([
            'name' => 'https://domain.ru',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }

    public function testDomainsIndex()
    {
        DB::table('domain_checks')->insert([
            'domain_id' => $this->id,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
            ]
        );
        $response = $this->get(route('domains'));
        $response->assertOk();
    }

    public function testDomainShow()
    {
        $response = $this->get(route('domain', ['id' => $this->id]));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
        $response->assertSee($this->id);
    }

    public function testDomainStore()
    {
        $response = $this->post(route('domains.store'), ['domain' => ['name' => 'https://newdomain.ru']]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domains', ['name' => 'https://newdomain.ru']);
    }
}
