<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUserAndReceiveToken()
    {
        $response = $this->post('/users', [
            'name' => 'Huanderson Machado',
            'email' => 'contato@huanderson.dev',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertJsonFragment([
                'name' => 'Huanderson Machado',
                'email' => 'contato@huanderson.dev',
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(201);
    }
}
