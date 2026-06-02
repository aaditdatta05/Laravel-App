<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => Str::lower(trim((string) $this->input('email'))),
        ]);
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique(User::class, 'employee_code')->ignore($user),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
}