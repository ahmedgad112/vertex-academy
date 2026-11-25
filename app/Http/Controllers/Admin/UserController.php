<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Support\RolePermissions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', User::class);

        $role = $request->string('role')->toString();
        $search = $request->string('search')->toString();

        $users = User::query()
            ->with('studentProfile')
            ->when(
                $role !== '' && UserRole::tryFrom($role),
                fn ($query) => $query->where('role', $role),
            )
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                }),
            )
            ->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn (User $user) => $this->transform($user));

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => [
                'role' => $role !== '' ? $role : null,
                'search' => $search !== '' ? $search : null,
            ],
            'roles' => $this->roleOptions(),
            'permissionMatrix' => RolePermissions::matrix(),
            'can' => [
                'create' => $request->user()->can('create', User::class),
            ],
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create', User::class);

        return Inertia::render('Admin/Users/Form', [
            'user' => null,
            'roles' => $this->roleOptions(),
            'permissionMatrix' => RolePermissions::matrix(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $role = UserRole::from($validated['role']);

        DB::transaction(function () use ($validated, $role) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $role,
                'is_active' => $validated['is_active'] ?? true,
                'email_verified_at' => now(),
            ]);

            if ($role === UserRole::Student) {
                $user->studentProfile()->create([
                    'id_passport' => $validated['id_passport'] ?? null,
                    'phone' => $validated['phone'] ?? null,
                    'affiliation' => $validated['affiliation'] ?? null,
                    'country' => $validated['country'] ?? null,
                    'certificates_note' => $validated['certificates_note'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): Response
    {
        Gate::authorize('update', $user);

        $user->load('studentProfile');

        return Inertia::render('Admin/Users/Form', [
            'user' => [
                ...$this->transform($user),
                'id_passport' => $user->studentProfile?->id_passport,
                'phone' => $user->studentProfile?->phone,
                'country' => $user->studentProfile?->country,
                'certificates_note' => $user->studentProfile?->certificates_note,
            ],
            'roles' => $this->roleOptions(),
            'permissionMatrix' => RolePermissions::matrix(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $role = UserRole::from($validated['role']);

        if (
            $user->role === UserRole::Admin
            && (
                $role !== UserRole::Admin
                || ($validated['is_active'] === false)
            )
            && $this->activeAdminCountExcluding($user) < 1
        ) {
            return back()->withErrors([
                'role' => 'The academy must keep at least one active admin.',
            ]);
        }

        DB::transaction(function () use ($user, $validated, $role) {
            $payload = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $role,
                'is_active' => $validated['is_active'],
            ];

            if (! empty($validated['password'])) {
                $payload['password'] = $validated['password'];
            }

            $user->update($payload);

            if ($role === UserRole::Student) {
                $user->studentProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'id_passport' => $validated['id_passport'] ?? null,
                        'phone' => $validated['phone'] ?? null,
                        'affiliation' => $validated['affiliation'] ?? null,
                        'country' => $validated['country'] ?? null,
                        'certificates_note' => $validated['certificates_note'] ?? null,
                    ],
                );
            } else {
                $user->studentProfile()?->delete();
            }
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function transform(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->value,
            'role_label' => $user->role->label(),
            'is_active' => $user->is_active,
            'permissions' => $user->permissionValues(),
            'affiliation' => $user->studentProfile?->affiliation,
            'created_at' => $user->created_at?->toDateString(),
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    protected function roleOptions(): array
    {
        return collect(UserRole::cases())->map(fn (UserRole $item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->all();
    }

    protected function activeAdminCountExcluding(User $user): int
    {
        return User::query()
            ->where('role', UserRole::Admin)
            ->where('is_active', true)
            ->whereKeyNot($user->id)
            ->count();
    }
}
