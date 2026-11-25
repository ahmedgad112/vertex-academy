<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Auth/Register')
            ->has('countries')
            ->where('countries.0.name', 'Egypt'));
    }

    public function test_new_students_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'id_passport' => 'P998877',
            'phone' => '+201111111111',
            'affiliation' => 'Demo Lab',
            'country' => 'Egypt',
            'certificates_note' => 'BSc MLS',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('student.dashboard', absolute: false));

        $user = User::query()->where('email', 'student@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame(UserRole::Student, $user->role);
        $this->assertDatabaseHas('student_profiles', [
            'user_id' => $user->id,
            'id_passport' => 'P998877',
            'affiliation' => 'Demo Lab',
            'country' => 'Egypt',
            'phone' => '+201111111111',
        ]);
    }

    public function test_registration_requires_country_and_phone(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'id_passport' => 'P998877',
            'affiliation' => 'Demo Lab',
            'country' => '',
            'phone' => '',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['country', 'phone']);
        $this->assertGuest();
    }
}
