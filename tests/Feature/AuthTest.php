<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User as User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
	protected $email = 'admin@admin.com';
	protected $password = 'secret';

    public function testLogin()
    {
    	$user = User::where('email', $this->email)->first();

        $response = $this->actingAs($user)->get('/login');

    	$response->assertRedirect('/dashboard');
    }
}
