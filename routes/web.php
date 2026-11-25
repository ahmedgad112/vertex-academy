<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Student\CourseCatalogController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\LibraryController;
use App\Support\Portal;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::post('/locale/{locale}', [LocaleController::class, 'update'])
    ->name('locale.update');

Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(Portal::homeRoute(auth()->user()));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:student', 'permission:access_student_portal'])
        ->prefix('student')
        ->name('student.')
        ->group(function () {
            Route::get('/', StudentDashboardController::class)->name('dashboard');

            Route::middleware('permission:enroll_in_programs')->group(function () {
                Route::get('/courses', [CourseCatalogController::class, 'index'])->name('courses.index');
                Route::get('/courses/{course:slug}', [CourseCatalogController::class, 'show'])->name('courses.show');
                Route::post('/courses/{course:slug}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
                Route::get('/courses/{course:slug}/checkout', [EnrollmentController::class, 'checkout'])->name('courses.checkout');
                Route::post('/courses/{course:slug}/pay', [EnrollmentController::class, 'pay'])->name('courses.pay');
            });

            Route::middleware('permission:access_library')->group(function () {
                Route::get('/library', LibraryController::class)->name('library');
            });
        });

    Route::middleware(['role:instructor', 'permission:access_instructor_portal'])
        ->prefix('instructor')
        ->name('instructor.')
        ->group(function () {
            Route::get('/', InstructorDashboardController::class)->name('dashboard');

            Route::middleware('permission:manage_own_courses')->group(function () {
                Route::get('/courses', [InstructorCourseController::class, 'index'])->name('courses.index');
                Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
                Route::post('/courses', [InstructorCourseController::class, 'store'])->name('courses.store');
                Route::get('/courses/{course}/edit', [InstructorCourseController::class, 'edit'])->name('courses.edit');
                Route::put('/courses/{course}', [InstructorCourseController::class, 'update'])->name('courses.update');
            });
        });

    Route::middleware(['role:admin', 'permission:access_admin_portal'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', AdminDashboardController::class)->name('dashboard');

            Route::middleware('permission:view_users')->group(function () {
                Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
            });

            Route::middleware('permission:create_users')->group(function () {
                Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
                Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
            });

            Route::middleware('permission:update_users')->group(function () {
                Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
                Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
            });

            Route::middleware('permission:delete_users')->group(function () {
                Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
            });

            Route::middleware('permission:manage_courses')->group(function () {
                Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
                Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
                Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
                Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
                Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
                Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
            });
        });
});

require __DIR__.'/auth.php';
