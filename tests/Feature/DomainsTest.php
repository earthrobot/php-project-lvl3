<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DomainsTest extends TestCase
{
    private int $id;
    private string $name;
    
    /**
     * A basic feature test.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = 'https://domain.ru';
        $this->id = DB::table('domains')->insertGetId([
            'name' => $this->name,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);

        DB::table('domain_checks')->insert([
            'domain_id' => $this->id,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }

    public function testDomainsIndex() : void
    {
        $response = $this->get(route('domains.index'));
        $response->assertOk();
    }

    public function testDomainShow() : void
    {
        $response = $this->get(route('domains.show', ['id' => $this->id]));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
        $response->assertSee($this->name);
    }

    public function testDomainStore() : void
    {
        $domainName = 'https://newdomain.ru';
        $response = $this->post(route('domains.store'), ['domain' => ['name' => $domainName]]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domains', ['name' => $domainName]);
        $id = DB::table('domains')->where('name', $domainName)->value('id');
        $response->assertRedirect(route('domains.show', ['id' => $id]));
    }

    public function testDomainStoreIfDomainExists() : void
    {
        $response = $this->post(route('domains.store'), ['domain' => ['name' => $this->name]]);
        $response->assertRedirect(route('domains.show', ['id' => $this->id]));
    }
}
