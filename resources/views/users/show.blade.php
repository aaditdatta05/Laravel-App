<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('User Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Review the selected user profile and account status.') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    {{ __('Edit User') }}
                </a>
                <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 px-6 py-4">
                    @if ($user->status === 'active')
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ __('Active') }}</span>
                    @else
                        <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">{{ __('Inactive') }}</span>
                    @endif
                </div>

                <div class="grid gap-6 p-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Employee Code') }}</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $user->employee_code ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Name') }}</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $user->name ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Email') }}</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Phone') }}</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $user->phone ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Role') }}</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $user->role?->name ?? 'Unassigned' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('User ID') }}</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $user->id }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 border-t border-gray-200 px-6 py-4">
                    <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                        {{ __('Edit') }}
                    </a>

                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('{{ __('Delete this user?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>