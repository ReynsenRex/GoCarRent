
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome to Customer Dashboard!</h3>
                    <p>You are logged in as: <strong>{{ auth()->user()->name }}</strong></p>
                    <p>Role: <strong>{{ auth()->user()->role->name }}</strong></p>
                    
                    <div class="mt-6">
                        <a href="{{ url('/') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Browse Cars
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>