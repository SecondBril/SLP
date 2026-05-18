<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_submit_data_admin()
    {
        $response = $this->post('/register', [
            'name' => 'test aja',
            'email' => 'tesuser' . rand(1, 9999) . '@gmail.com',
            'password' => 'testpass!!!',
            'password_confirmation' => 'testpass!!!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}
