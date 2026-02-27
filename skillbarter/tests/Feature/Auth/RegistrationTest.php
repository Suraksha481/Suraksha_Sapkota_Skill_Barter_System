<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_are_stored_pending_and_sent_verification_code(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'student',
        ]);

        // registration should not log the user in
        $this->assertGuest();

        // no user record should exist yet
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);

        // pending data should live in session
        $this->assertTrue(session()->has('pending_registration'));
        $pending = session('pending_registration');
        $this->assertEquals('Test User', $pending['name']);
        $this->assertEquals('test@example.com', $pending['email']);
        $this->assertEquals('student', $pending['role']);

        $response->assertRedirect(route('verify-email-code.show'));
    }
}
