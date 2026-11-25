<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Support\CoursePresenter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LibraryController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $library = Enrollment::query()
            ->with(['course.instructor'])
            ->where('user_id', $request->user()->id)
            ->unlocked()
            ->latest('unlocked_at')
            ->get()
            ->map(fn (Enrollment $enrollment) => CoursePresenter::toArray($enrollment->course, $enrollment));

        $pending = Enrollment::query()
            ->with(['course.instructor'])
            ->where('user_id', $request->user()->id)
            ->where('status', 'pending_payment')
            ->latest()
            ->get()
            ->map(fn (Enrollment $enrollment) => CoursePresenter::toArray($enrollment->course, $enrollment));

        return Inertia::render('Student/Library/Index', [
            'library' => $library,
            'pending' => $pending,
        ]);
    }
}
