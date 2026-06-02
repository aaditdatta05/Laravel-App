<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Create User') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Add a new user account to the system.') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                @include('users.partials.form', ['user' => null, 'roles' => $roles])
            </div>
        </div>
    </div>
</x-app-layout>