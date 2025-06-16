<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 -mx-6 -mt-6 px-6 pt-6 pb-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            <i class="fas fa-tachometer-alt mr-3"></i>Customer Dashboard
                        </h2>
                        <p class="text-blue-100 mt-2 text-lg">Selamat datang kembali, {{ auth()->user()->name }}!</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ date('d') }}</div>
                            <div class="text-blue-100 text-sm">{{ date('M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Browse Cars -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Cari Mobil</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Temukan mobil impian Anda</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('customer.cars.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-search mr-2"></i>
                                Mulai Pencarian
                            </a>
                        </div>
                    </div>
                </div>

                <!-- My Bookings -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Pemesanan Saya</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Lihat riwayat pemesanan</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('customer.bookings.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm font-medium rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-list mr-2"></i>
                                Lihat Pemesanan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Profil Saya</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Kelola informasi akun</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-chart-line mr-3 text-blue-600"></i>Ringkasan Aktivitas
                    </h3>
                    
                    @php
                        $totalBookings = \App\Models\Booking::where('user_id', auth()->id())->count();
                        $pendingBookings = \App\Models\Booking::where('user_id', auth()->id())->where('status', 'pending')->count();
                        $completedBookings = \App\Models\Booking::where('user_id', auth()->id())->where('status', 'completed')->count();
                        $inProgressBookings = \App\Models\Booking::where('user_id', auth()->id())->where('status', 'in_progress')->count();
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-6 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <i class="fas fa-clipboard-list text-blue-600 text-2xl mr-4"></i>
                                <div>
                                    <p class="text-sm text-blue-600 dark:text-blue-300 font-medium">Total Pemesanan</p>
                                    <p class="text-3xl font-bold text-blue-800 dark:text-blue-100">{{ $totalBookings }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900 dark:to-yellow-800 p-6 rounded-lg border-l-4 border-yellow-500">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-yellow-600 text-2xl mr-4"></i>
                                <div>
                                    <p class="text-sm text-yellow-600 dark:text-yellow-300 font-medium">Menunggu Konfirmasi</p>
                                    <p class="text-3xl font-bold text-yellow-800 dark:text-yellow-100">{{ $pendingBookings }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900 dark:to-indigo-800 p-6 rounded-lg border-l-4 border-indigo-500">
                            <div class="flex items-center">
                                <i class="fas fa-car text-indigo-600 text-2xl mr-4"></i>
                                <div>
                                    <p class="text-sm text-indigo-600 dark:text-indigo-300 font-medium">Sedang Berlangsung</p>
                                    <p class="text-3xl font-bold text-indigo-800 dark:text-indigo-100">{{ $inProgressBookings }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-6 rounded-lg border-l-4 border-green-500">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 text-2xl mr-4"></i>
                                <div>
                                    <p class="text-sm text-green-600 dark:text-green-300 font-medium">Selesai</p>
                                    <p class="text-3xl font-bold text-green-800 dark:text-green-100">{{ $completedBookings }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($totalBookings == 0)
                        <div class="mt-8 text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-car text-white text-3xl"></i>
                            </div>
                            <h4 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum Ada Pemesanan</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">Mulai jelajahi koleksi mobil kami dan buat pemesanan pertama Anda untuk pengalaman rental yang tak terlupakan!</p>
                            <a href="{{ route('customer.cars.index') }}" 
                               class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-search mr-2"></i>
                                Jelajahi Mobil Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity or Tips -->
            @if($totalBookings > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Bookings -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-history mr-2 text-green-600"></i>Pemesanan Terbaru
                            </h3>
                            @php
                                $recentBookings = \App\Models\Booking::where('user_id', auth()->id())
                                    ->with('car')
                                    ->latest()
                                    ->take(3)
                                    ->get();
                            @endphp
                            
                            <div class="space-y-3">
                                @foreach($recentBookings as $booking)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-car text-white"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                            @elseif($booking->status === 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('customer.bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Semua Pemesanan →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>Tips & Informasi
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Pesan Lebih Awal</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Dapatkan harga terbaik dengan memesan mobil minimal 3 hari sebelumnya.</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-shield-alt text-blue-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Asuransi Tersedia</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Lindungi perjalanan Anda dengan asuransi komprehensif kami.</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone text-purple-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">24/7 Support</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Tim customer service kami siap membantu kapan saja.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>