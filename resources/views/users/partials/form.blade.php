@php
    $isEdit = isset($user) && $user;
@endphp

<form method="POST" action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="mt-1 block w-full" type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="mt-1 block w-full" type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="employee_code" :value="__('Employee Code')" />
            <x-text-input id="employee_code" class="mt-1 block w-full" type="text" name="employee_code" value="{{ old('employee_code', $user->employee_code ?? '') }}" required autocomplete="off" />
            <x-input-error :messages="$errors->get('employee_code')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="mt-1 block w-full" type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role_id" :value="__('Role')" />
            <select id="role_id" name="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">{{ __('Select Role') }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>{{ __('Active') }}</option>
                <option value="inactive" @selected(old('status', $user->status ?? '') === 'inactive')>{{ __('Inactive') }}</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" @if(! $isEdit) required @endif autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            @if ($isEdit)
                <p class="mt-2 text-sm text-gray-500">{{ __('Leave blank to keep the current password.') }}</p>
            @endif
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" @if(! $isEdit) required @endif autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 pt-2">
        <x-primary-button>
            {{ $isEdit ? __('Update User') : __('Create User') }}
        </x-primary-button>

        <a href="{{ route('users.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
            {{ __('Cancel') }}
        </a>
    </div>
</form>