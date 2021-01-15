<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DomainCheckTest extends TestCase
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

    public function testDomainCheckStore()
    {
        $pathParts = [__DIR__, 'fixtures', 'htmlDocument.txt'];
        $body = file_get_contents(implode("/", $pathParts));

        Http::fake(fn($request) => Http::response($body, 200));

        $response = $this->post(route('domain.check', ['id' => $this->id]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('domain_checks', [
            'domain_id' => $this->id, 
            'status_code' => 200, 
            'h1' => 'Page title', 
            'keywords' => 'keyword1, keyword2, keyword3', 
            'description' => 'page description',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }
}
