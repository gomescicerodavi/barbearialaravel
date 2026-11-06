<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_register_and_is_logged_in(): void
    {
        $this->post(route('register'), [
            'name' => 'Torcedor',
            'email' => '  TORCEDOR@EXAMPLE.COM  ',
            'password' => 'senha-segura-123',
            'password_confirmation' => 'senha-segura-123',
        ])->assertRedirect('/#quiz');

        $user = User::first();
        $this->assertSame('torcedor@example.com', $user->email);
        $this->assertAuthenticatedAs($user);
    }

    public function test_a_registered_user_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'email' => 'player@example.com',
            'password' => 'senha-segura-123',
        ]);

        $this->post(route('login'), [
            'email' => 'PLAYER@EXAMPLE.COM',
            'password' => 'senha-segura-123',
        ])->assertRedirect('/#quiz');
        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect('/#quiz');
        $this->assertGuest();
    }

    public function test_a_duplicate_account_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'player@example.com']);

        $this->from('/#quiz')->post(route('register'), [
            'name' => 'Torcedor',
            'email' => 'PLAYER@example.com',
            'password' => 'senha-segura-123',
            'password_confirmation' => 'senha-segura-123',
        ])->assertRedirect('/#quiz')
            ->assertSessionHasErrorsIn('register', 'email');

        $this->assertSame(1, User::count());
    }
}
