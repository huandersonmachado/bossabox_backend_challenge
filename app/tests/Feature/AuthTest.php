<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginUserSuccess()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(1);
    }

    public function testLoginUserFail()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password_wrong'
        ]);


        $response->assertStatus(200);

        $response->assertJsonFragment([
            'error' => 'The given data was invalid.'
        ]);
    }
}
