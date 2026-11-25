<?php

namespace Tests\Feature\Admin;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_instructor(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New Instructor',
            'email' => 'new.instructor@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRole::Instructor->value,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'new.instructor@example.com',
            'role' => UserRole::Instructor->value,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_user_role_and_status(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->student()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $student), [
            'name' => $student->name,
            'email' => $student->email,
            'role' => UserRole::Instructor->value,
            'is_active' => false,
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'role' => UserRole::Instructor->value,
            'is_active' => false,
        ]);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->student()->inactive()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_student_cannot_manage_users(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get(route('admin.users.index'))
            ->assertRedirect(route('student.dashboard'));
    }

    public function test_admin_has_expected_permissions(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertTrue($admin->hasPermission(Permission::ViewUsers));
        $this->assertTrue($admin->hasPermission(Permission::CreateUsers));
        $this->assertTrue($admin->can(Permission::DeleteUsers->value));
    }

    public function test_cannot_delete_last_active_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertForbidden();
    }
}
