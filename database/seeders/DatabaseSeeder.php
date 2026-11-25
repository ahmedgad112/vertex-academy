<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@vertex-academy.com'],
            [
                'name' => 'Vertex Admin',
                'password' => 'password',
                'role' => UserRole::Admin,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        $instructor = User::query()->updateOrCreate(
            ['email' => 'instructor@vertex-academy.com'],
            [
                'name' => 'Vertex Instructor',
                'password' => 'password',
                'role' => UserRole::Instructor,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        $student = User::query()->updateOrCreate(
            ['email' => 'student@vertex-academy.com'],
            [
                'name' => 'Vertex Student',
                'password' => 'password',
                'role' => UserRole::Student,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        $student->studentProfile()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'id_passport' => 'A1234567',
                'phone' => '+201000000000',
                'affiliation' => 'Vertex Demo Hospital',
                'country' => 'Egypt',
                'certificates_note' => 'Demo student profile',
            ],
        );

        $this->call(CourseSeeder::class);

        unset($admin, $instructor);
    }
}
