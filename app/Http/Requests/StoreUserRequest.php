<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'employee_code' => ['required', 'string', 'max:50', 'unique:' . User::class . ',employee_code'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}