<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_open_student_portal(): void
    {
        $user = User::factory()->student()->create();

        $this->actingAs($user)
            ->get(route('student.dashboard'))
            ->assertOk();
    }

    public function test_student_cannot_open_admin_portal(): void
    {
        $user = User::factory()->student()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('student.dashboard'));
    }

    public function test_admin_can_view_users_directory(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->student()->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk();
    }

    public function test_dashboard_alias_redirects_by_role(): void
    {
        $instructor = User::factory()->instructor()->create();

        $this->actingAs($instructor)
            ->get(route('dashboard'))
            ->assertRedirect(route('instructor.dashboard'));
    }
}
