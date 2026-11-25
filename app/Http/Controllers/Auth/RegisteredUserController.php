<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Countries;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the student registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'countries' => Countries::options(),
        ]);
    }

    /**
     * Handle an incoming student registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_passport' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:40'],
            'affiliation' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:120', Rule::in(Countries::names())],
            'certificates_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => UserRole::Student,
                'email_verified_at' => now(),
            ]);

            $user->studentProfile()->create([
                'id_passport' => $validated['id_passport'],
                'phone' => $validated['phone'],
                'affiliation' => $validated['affiliation'],
                'country' => $validated['country'],
                'certificates_note' => $validated['certificates_note'] ?? null,
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('student.dashboard');
    }
}
