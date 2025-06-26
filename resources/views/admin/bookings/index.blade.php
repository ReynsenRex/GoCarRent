<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-black leading-tight">
                {{ __('All Bookings Management') }}
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
                    <!-- Filter Section -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-lg font-medium mb-4">Filter Bookings</h4>
                        <form method="GET" action="{{ route('admin.bookings.index') }}"
                            class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Status
                                </label>
                                <select name="status" id="status"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                    <option value="in_progress"
                                        {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>

                            <!-- Start Date Filter -->
                            <div>
                                <label for="start_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    From Date
                                </label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ request('start_date') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- End Date Filter -->
                            <div>
                                <label for="end_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    To Date
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Filter Buttons -->
                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Filter
                                </button>
                                <a href="{{ route('admin.bookings.index') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200 text-sm">Total Bookings</h4>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $bookings->total() }}</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 text-sm">Pending</h4>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ \App\Models\Booking::where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200 text-sm">Approved</h4>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ \App\Models\Booking::where('status', 'approved')->count() }}</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200 text-sm">In Progress</h4>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                {{ \App\Models\Booking::where('status', 'in_progress')->count() }}</p>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 text-sm">Completed</h4>
                            <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">
                                {{ \App\Models\Booking::where('status', 'completed')->count() }}</p>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-red-800 dark:text-red-200 text-sm">Cancelled/Rejected</h4>
                            <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                                {{ \App\Models\Booking::whereIn('status', ['cancelled', 'rejected'])->count() }}</p>
                        </div>
                    </div>

                    @if ($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full lg:min-w-max divide-y divide-gray-200 dark:divide-gray-700" style="min-width: 1200px;">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Booking ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Car
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Booking Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Rental Period
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total Price
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-48">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($bookings as $booking)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
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
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                <div>{{ $booking->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $booking->created_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                <div>{{ $booking->start_date->format('M d, Y') }}</div>
                                                <div class="text-gray-500 dark:text-gray-400">to</div>
                                                <div>{{ $booking->end_date->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    ({{ $booking->start_date->diffInDays($booking->end_date) + 1 }}
                                                    days)
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    @switch($booking->status)
                                                        @case('pending')
                                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                            @break
                                                        @case('approved')
                                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                            @break
                                                        @case('rejected')
                                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                            @break
                                                        @case('in_progress')
                                                            bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                            @break
                                                        @case('completed')
                                                            bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300
                                                            @break
                                                        @case('cancelled')
                                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                            @break
                                                        @default
                                                            bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300
                                                    @endswitch
                                                ">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium w-48">
                                                <div class="flex flex-wrap gap-1">
                                                    <!-- View Details Button -->
                                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                                        class="inline-flex items-center px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-800 text-xs font-medium rounded transition duration-200 dark:bg-indigo-800 dark:text-indigo-200 dark:hover:bg-indigo-700">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                        View
                                                    </a>

                                                    @if ($booking->status === 'pending')
                                                        <!-- Approve Button -->
                                                        <form method="POST"
                                                            action="{{ route('admin.bookings.approve', $booking) }}"
                                                            onsubmit="return confirm('Are you sure you want to approve this booking?')"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="inline-flex items-center px-2 py-1 bg-green-100 hover:bg-green-200 text-green-800 text-xs font-medium rounded transition duration-200 dark:bg-green-800 dark:text-green-200 dark:hover:bg-green-700">
                                                                ✓ Approve
                                                            </button>
                                                        </form>

                                                        <!-- Reject Button -->
                                                        <form method="POST"
                                                            action="{{ route('admin.bookings.reject', $booking) }}"
                                                            onsubmit="return confirm('Are you sure you want to reject this booking?')"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-800 text-xs font-medium rounded transition duration-200 dark:bg-red-800 dark:text-red-200 dark:hover:bg-red-700">
                                                                ✗ Reject
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($booking->status === 'in_progress')
                                                        <!-- Complete Button -->
                                                        <form method="POST"
                                                            action="{{ route('admin.bookings.complete', $booking) }}"
                                                            onsubmit="return confirm('Are you sure you want to mark this booking as completed?')"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-medium rounded transition duration-200 dark:bg-blue-800 dark:text-blue-200 dark:hover:bg-blue-700">
                                                                ✓ Complete
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if (in_array($booking->status, ['pending', 'approved']))
                                                        <!-- Cancel Button -->
                                                        <form method="POST"
                                                            action="{{ route('admin.bookings.cancel', $booking) }}"
                                                            onsubmit="return confirm('Are you sure you want to cancel this booking?')"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="inline-flex items-center px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-medium rounded transition duration-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                                                ✗ Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $bookings->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 dark:text-gray-400 text-lg mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Bookings Found
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                @if (request()->hasAny(['status', 'start_date', 'end_date']))
                                    No bookings match your current filters. Try adjusting your search criteria.
                                @else
                                    There are currently no bookings in the system.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
            id="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
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
