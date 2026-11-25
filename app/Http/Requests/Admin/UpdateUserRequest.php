<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->route('user');

        return $this->user()?->can('update', $user) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::enum(UserRole::class)],
            'is_active' => ['required', 'boolean'],
            'id_passport' => ['nullable', 'required_if:role,student', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:40'],
            'affiliation' => ['nullable', 'required_if:role,student', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:120'],
            'certificates_note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
