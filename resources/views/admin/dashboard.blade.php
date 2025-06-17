<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('In Progress Bookings') }}
            </h2>

            <div class="flex space-x-2 items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome to Admin Dashboard!</h3>
                    <p>You are logged in as: <strong>{{ auth()->user()->name }}</strong></p>
                    <p>Role: <strong>{{ auth()->user()->role->name }}</strong></p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Users</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\User::count() }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Total Cars</h4>
                            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Car::count() }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Total Bookings</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Booking::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">In Progress Bookings Management</h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Total: {{ $bookings->total() }} bookings
                        </div>
                    </div>

                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Booking ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Car
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Rental Period
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Created At
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                #{{ $booking->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $booking->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $booking->user->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $booking->car->brand }} {{ $booking->car->model }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $booking->car->year }} - {{ $booking->car->license_plate }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                <div>{{ $booking->start_date->format('M d, Y') }}</div>
                                                <div class="text-gray-500 dark:text-gray-400">to</div>
                                                <div>{{ $booking->end_date->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    ({{ $booking->start_date->diffInDays($booking->end_date) }} days)
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $booking->status === 'pending' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $booking->created_at->format('M d, Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- Approve Button -->
                                                    <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" 
                                                          onsubmit="return confirm('Are you sure you want to approve this booking?')" 
                                                          class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium transition duration-200">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <!-- Reject Button -->
                                                    <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" 
                                                          onsubmit="return confirm('Are you sure you want to reject this booking?')" 
                                                          class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-medium transition duration-200">
                                                            Reject
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 dark:text-gray-400 text-lg mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No In Progress Bookings</h3>
                            <p class="text-gray-500 dark:text-gray-400">There are currently no bookings in progress.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="error-message">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Auto-hide success/error messages
        setTimeout(() => {
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 5000);
    </script>
</x-app-layout>