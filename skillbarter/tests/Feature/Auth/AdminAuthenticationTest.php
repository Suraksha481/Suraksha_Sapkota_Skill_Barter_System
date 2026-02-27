<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_default_admin_is_created_and_can_authenticate(): void
    {
        $this->assertSame(0, Admin::count());

        $response = $this->post('/admin/login', [
            'email' => 'admin@skillxchange.com',
            'password' => 'admin123',
        ]);

        $this->assertAuthenticated('admin');
        $this->assertTrue(Admin::where('email', 'admin@skillxchange.com')->exists());
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_invalid_credentials_do_not_authenticate(): void
    {
        // create an admin record so attempt will run normally
        Admin::create([
            'name' => 'Test',
            'email' => 'foo@bar.com',
            'password' => bcrypt('secret'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'foo@bar.com',
            'password' => 'wrong',
        ]);

        $this->assertGuest('admin');
        $response->assertSessionHasErrors('email');
    }
}
