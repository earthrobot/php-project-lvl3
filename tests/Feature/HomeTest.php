<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }
}
