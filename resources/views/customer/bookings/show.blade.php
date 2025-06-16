<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fas fa-file-invoice mr-2"></i>Detail Pemesanan #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
            </h2>
            <a href="{{ route('customer.bookings.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Booking Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <!-- Status Badge -->
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Informasi Pemesanan
                                </h3>
                                @switch($booking->status)
                                    @case('pending')
                                        <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-2"></i>Menunggu Konfirmasi
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-2"></i>Disetujui
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-2"></i>Ditolak
                                        </span>
                                        @break
                                    @case('in_progress')
                                        <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <i class="fas fa-car mr-2"></i>Sedang Berlangsung
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <i class="fas fa-flag-checkered mr-2"></i>Selesai
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <i class="fas fa-ban mr-2"></i>Dibatalkan
                                        </span>
                                        @break
                                @endswitch
                            </div>

                            <!-- Car Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                    <i class="fas fa-car mr-2"></i>Informasi Mobil
                                </h4>
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($booking->car->image_url)
                                            <img src="{{ Storage::url($booking->car->image_url) }}" 
                                                 alt="{{ $booking->car->brand }} {{ $booking->car->model }}"
                                                 class="w-24 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-24 h-16 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">{{ $booking->car->brand }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900 dark:text-white">
                                            {{ $booking->car->brand }} {{ $booking->car->model }}
                                        </h5>
                                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-300 mt-2">
                                            <div>Tahun: {{ $booking->car->year }}</div>
                                            <div>Transmisi: {{ ucfirst($booking->car->transmission) }}</div>
                                            <div>Kapasitas: {{ $booking->car->capacity }} orang</div>
                                            <div>Bahan Bakar: {{ ucfirst($booking->car->fuel_type) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>Detail Sewa
                                    </h4>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Tanggal Mulai:</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Tanggal Selesai:</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Durasi:</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} hari
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Tanggal Pesan:</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ $booking->created_at->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <i class="fas fa-money-bill-wave mr-2"></i>Rincian Harga
                                    </h4>
                                    <div class="space-y-3 text-sm">
                                        @php
                                            $days = \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1;
                                            $pricePerDay = $booking->car->price_per_day;
                                            $subtotal = $days * $pricePerDay;
                                            $tax = $subtotal * 0.1;
                                            $total = $subtotal + $tax;
                                        @endphp
                                        
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Harga per hari:</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                Rp {{ number_format($pricePerDay, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Subtotal ({{ $days }} hari):</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Pajak (10%):</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                Rp {{ number_format($tax, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <hr class="border-gray-300 dark:border-gray-600">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span class="text-gray-900 dark:text-white">Total:</span>
                                            <span class="text-blue-600 dark:text-blue-400">
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($booking->notes)
                                <div class="mt-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <i class="fas fa-sticky-note mr-2"></i>Catatan
                                    </h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-gray-600 dark:text-gray-300">{{ $booking->notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi</h3>
                            
                            <div class="space-y-3">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('customer.bookings.cancel', $booking->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                                            <i class="fas fa-times mr-2"></i>Batalkan Pemesanan
                                        </button>
                                    </form>
                                @elseif($booking->status === 'approved')
                                    @if(!$booking->payment)
                                        <a href="{{ route('customer.payments.create', $booking->id) }}" 
                                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                                            <i class="fas fa-credit-card mr-2"></i>Bayar Sekarang
                                        </a>
                                    @else
                                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-center">
                                            <i class="fas fa-check-circle mr-2"></i>Pembayaran Selesai
                                        </div>
                                    @endif
                                @elseif($booking->status === 'in_progress')
                                    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-center">
                                        <i class="fas fa-car mr-2"></i>Sedang Berlangsung
                                    </div>
                                @endif

                                <a href="{{ route('customer.cars.show', $booking->car->id) }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-eye mr-2"></i>Lihat Mobil
                                </a>

                                <a href="{{ route('customer.bookings.index') }}" 
                                   class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-list mr-2"></i>Semua Pemesanan
                                </a>
                            </div>

                            <!-- Contact Info -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Butuh Bantuan?</h4>
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-2"></i>
                                        <span>+62 812-3456-7890</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-2"></i>
                                        <span>support@gocarrent.com</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        <span>WhatsApp: +62 812-3456-7890</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status (if exists) -->
                    @if($booking->payment)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mt-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-credit-card mr-2"></i>Status Pembayaran
                                </h3>
                                
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Transaction ID:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $booking->payment->transaction_id }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Status:</span>
                                        <span class="font-medium text-green-600">
                                            {!! $booking->payment->status_badge !!}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Jumlah:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $booking->payment->formatted_amount }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Metode:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Tanggal Bayar:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ $booking->payment->paid_at ? $booking->payment->paid_at->format('d M Y H:i') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>