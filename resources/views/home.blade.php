<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoCarRent - Premium Car Rental Service</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">GoCarRent</h1>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-medium">Beranda</a>
                    @auth
                        <a href="{{ route('customer.cars.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Cari Mobil</a>
                        <a href="{{ route('customer.bookings.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Pemesanan Saya</a>
                    @endauth
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Tentang</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Kontak</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @if (auth()->check())
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            Daftar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Sewa Mobil Terpercaya
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Temukan kendaraan impian Anda dengan harga terbaik
                </p>
                
                <!-- Functional Search Form -->
                @auth
                <form method="GET" action="{{ route('customer.cars.index') }}" class="bg-white rounded-lg shadow-xl p-6 max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Location -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <select name="location" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                                <option value="">Semua Lokasi</option>
                                <option value="jakarta">Jakarta</option>
                                <option value="surabaya">Surabaya</option>
                                <option value="bandung">Bandung</option>
                                <option value="medan">Medan</option>
                            </select>
                        </div>
                        
                        <!-- Start Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" min="{{ date('Y-m-d') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                        </div>
                        
                        <!-- End Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="end_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                        </div>
                        
                        <!-- Search Button -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-lg font-medium transition duration-200">
                                Cari Mobil
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl mx-auto">
                    <div class="text-center">
                        <p class="text-gray-600 mb-4">Silakan login untuk mencari dan memesan mobil</p>
                        <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                            Login Sekarang
                        </a>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </section>

    <!-- Welcome Message -->
    @if (auth()->check())
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-auto max-w-7xl mt-4" role="alert">
            <span class="block sm:inline">Selamat datang, {{ auth()->user()->name }}! Role Anda: {{ auth()->user()->role->name ?? 'Unknown' }}</span>
        </div>
    @endif

    <!-- Popular Cars Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mobil Popular</h2>
                <p class="text-gray-600">Pilihan mobil terbaik dan terpopuler dari kami</p>
                @auth
                    <a href="{{ route('customer.cars.index') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        Lihat Semua Mobil
                    </a>
                @endauth
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Sample cars - you can replace with dynamic data later -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">Toyota Avanza</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Toyota Avanza</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex justify-between">
                                <span>Transmisi:</span>
                                <span>Manual</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kapasitas:</span>
                                <span>7 Seats</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Bahan Bakar:</span>
                                <span>Petrol</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">Rp 250.000</span>
                                <span class="text-gray-500">/hari</span>
                            </div>
                            @auth
                                <a href="{{ route('customer.cars.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Login untuk Pesan
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">Honda Jazz</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Honda Jazz</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex justify-between">
                                <span>Transmisi:</span>
                                <span>Automatic</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kapasitas:</span>
                                <span>5 Seats</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Bahan Bakar:</span>
                                <span>Petrol</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">Rp 300.000</span>
                                <span class="text-gray-500">/hari</span>
                            </div>
                            @auth
                                <a href="{{ route('customer.cars.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Login untuk Pesan
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">Mitsubishi Xpander</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mitsubishi Xpander</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex justify-between">
                                <span>Transmisi:</span>
                                <span>Automatic</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kapasitas:</span>
                                <span>7 Seats</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Bahan Bakar:</span>
                                <span>Petrol</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">Rp 350.000</span>
                                <span class="text-gray-500">/hari</span>
                            </div>
                            @auth
                                <a href="{{ route('customer.cars.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                    Login untuk Pesan
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 GoCarRent. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Set minimum end date when start date changes
        const startDateInput = document.querySelector('input[name="start_date"]');
        const endDateInput = document.querySelector('input[name="end_date"]');
        
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                const startDate = new Date(this.value);
                const nextDay = new Date(startDate);
                nextDay.setDate(startDate.getDate() + 1);
                
                endDateInput.min = nextDay.toISOString().split('T')[0];
                if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                    endDateInput.value = nextDay.toISOString().split('T')[0];
                }
            });
        }
    </script>
</body>
</html>