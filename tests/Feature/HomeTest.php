<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomeTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testNotFoundTest()
    {
        $response = $this->get('mocos');
        $response->assertStatus(404);
    }
}
