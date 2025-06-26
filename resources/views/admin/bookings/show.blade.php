<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Booking Details') }} - #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
            </h2>

            <div class="flex space-x-2 items-center">
                <a href="{{ route('admin.bookings.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                    Back to Bookings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Booking Status Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Booking Status</h3>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
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
                        </div>
                        
                        <div class="flex space-x-2">
                            @if($booking->status === 'pending')
                                <!-- Approve Button -->
                                <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" 
                                    onsubmit="return confirm('Are you sure you want to approve this booking?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Approve Booking
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" 
                                    onsubmit="return confirm('Are you sure you want to reject this booking?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Reject Booking
                                    </button>
                                </form>
                            @endif

                            @if($booking->status === 'in_progress')
                                <!-- Complete Button -->
                                <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}" 
                                    onsubmit="return confirm('Are you sure you want to mark this booking as completed?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif

                            @if(in_array($booking->status, ['pending', 'approved']))
                                <!-- Cancel Button -->
                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" 
                                    onsubmit="return confirm('Are you sure you want to cancel this booking?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Customer Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="font-medium">Name:</span>
                                <span class="ml-2">{{ $booking->user->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Email:</span>
                                <span class="ml-2">{{ $booking->user->email }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Phone:</span>
                                <span class="ml-2">{{ $booking->user->phone ?? 'Not provided' }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Member Since:</span>
                                <span class="ml-2">{{ $booking->user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Car Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Car Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="font-medium">Car:</span>
                                <span class="ml-2">{{ $booking->car->brand }} {{ $booking->car->model }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Year:</span>
                                <span class="ml-2">{{ $booking->car->year }}</span>
                            </div>
                            <div>
                                <span class="font-medium">License Plate:</span>
                                <span class="ml-2">{{ $booking->car->license_plate }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Daily Rate:</span>
                                <span class="ml-2">Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Transmission:</span>
                                <span class="ml-2">{{ ucfirst($booking->car->transmission) }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Fuel Type:</span>
                                <span class="ml-2">{{ ucfirst($booking->car->fuel_type) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Booking Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">Booking Date:</span>
                            <p class="text-lg">{{ $booking->created_at->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->created_at->format('H:i') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">Start Date:</span>
                            <p class="text-lg">{{ $booking->start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">End Date:</span>
                            <p class="text-lg">{{ $booking->end_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">Duration:</span>
                            <p class="text-lg">{{ $booking->start_date->diffInDays($booking->end_date) + 1 }} days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Pricing Information</h3>
                    <div class="space-y-3">
                        @php
                            $duration = $booking->start_date->diffInDays($booking->end_date) + 1;
                            $basePrice = $booking->car->price_per_day * $duration;
                        @endphp
                        
                        <div class="flex justify-between">
                            <span>Daily Rate:</span>
                            <span>Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Duration:</span>
                            <span>{{ $duration }} days</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($basePrice, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($basePrice != $booking->total_price)
                            <div class="flex justify-between text-green-600">
                                <span>Discount/Adjustment:</span>
                                <span>Rp {{ number_format($booking->total_price - $basePrice, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        <hr class="border-gray-300 dark:border-gray-600">
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total Price:</span>
                            <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($booking->notes)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Notes</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $booking->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Booking Timeline -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Booking Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                            <div>
                                <p class="font-medium">Booking Created</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($booking->updated_at != $booking->created_at)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                                <div>
                                    <p class="font-medium">Last Updated</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-message">
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
