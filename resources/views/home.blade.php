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
                        <a href="{{ route('customer.cars.index') }}"
                            class="text-gray-600 hover:text-blue-600 font-medium">Cari Mobil</a>
                        <a href="{{ route('customer.bookings.index') }}"
                            class="text-gray-600 hover:text-blue-600 font-medium">Pemesanan Saya</a>
                    @endauth
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Tentang</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Kontak</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @if (auth()->check())
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
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
                    <form method="GET" action="{{ route('customer.cars.index') }}"
                        class="bg-white rounded-lg shadow-xl p-6 max-w-4xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Location -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <select name="location"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
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
                                <input type="date" name="start_date" min="{{ date('Y-m-d') }}"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                            </div>

                            <!-- End Date -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="end_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                            </div>

                            <!-- Search Button -->
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-lg font-medium transition duration-200">
                                    Cari Mobil
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl mx-auto">
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Silakan login untuk mencari dan memesan mobil</p>
                            <a href="{{ route('login') }}"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
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
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-auto max-w-7xl mt-4"
            role="alert">
            <span class="block sm:inline">Selamat datang, {{ auth()->user()->name }}! Role Anda:
                {{ auth()->user()->role->name ?? 'Unknown' }}</span>
        </div>
    @endif

    <!-- Popular Cars Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mobil Populer</h2>
                <p class="text-gray-600">Pilihan mobil terbaik dan terpopuler dari kami</p>
                @auth
                    <a href="{{ route('customer.cars.index') }}"
                        class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        Lihat Semua Mobil
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($cars as $car)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="h-48 bg-gray-200 flex items-center justify-center"
                            style="background-image: url('{{ $car->image_url ?? 'https://via.placeholder.com/400x200?text=No+Image' }}'); background-size: cover; background-position: center;">
                            <span class="sr-only">{{ $car->brand }} {{ $car->model }}</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $car->brand }} {{ $car->model }}
                            </h3>
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <div class="flex justify-between">
                                    <span>Transmisi:</span>
                                    <span>{{ ucfirst($car->transmission) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Kapasitas:</span>
                                    <span>{{ $car->capacity }} Seats</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Bahan Bakar:</span>
                                    <span>{{ $car->fuel_type }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold text-blue-600">Rp
                                        {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                                    <span class="text-gray-500">/hari</span>
                                </div>
                                @auth
                                    <a href="{{ route('customer.cars.index') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Login untuk Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold text-gray-900">Tentang Kami</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    GoCarRent adalah layanan sewa mobil premium yang berdedikasi memberikan pengalaman perjalanan
                    terbaik bagi pelanggan kami.
                    Dengan armada kendaraan yang lengkap dan layanan profesional, kami siap menemani setiap langkah
                    perjalanan Anda.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-blue-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 text-blue-600">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.75v16.5m-9-16.5v16.5M3 12h18" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Pilihan Mobil Lengkap</h3>
                    <p class="text-gray-600">Dari mobil city car hingga SUV mewah, semua tersedia dalam kondisi
                        terbaik.</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 text-blue-600">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6l4 2m6 4a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600">Kami siap melayani Anda kapan pun dibutuhkan — setiap hari, sepanjang
                        tahun.</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 text-blue-600">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L15 12 9.75 7.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cepat & Praktis</h3>
                    <p class="text-gray-600">Proses pemesanan mudah dan cepat langsung dari platform kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="bg-gray-100 py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold text-gray-900">Kontak Kami</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Ada pertanyaan? Kami dengan senang hati akan membantu Anda. Hubungi kami melalui kontak di bawah
                    ini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="text-blue-600 mb-4">
                        <svg class="mx-auto h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 3.487l.011.011c1.756 1.756 2.579 3.698 2.45 5.7-.13 2.003-.996 4.04-2.602 5.646-1.605 1.605-3.643 2.471-5.646 2.602-2.003.13-3.945-.694-5.7-2.45l-.011-.011A9.025 9.025 0 013 9.75c0-4.97 4.03-9 9-9 2.302 0 4.395.879 6.006 2.321l-.144.166z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h.01M15 12h.01M12 15h.01" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Alamat</h4>
                    <p class="text-gray-600">Jl. SiwalanKerto No.123<br>Surabaya, Indonesia</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="text-blue-600 mb-4">
                        <svg class="mx-auto h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 12h.01M12 12h.01M8 12h.01M21 12c0 4.418-7.164 7.997-9 8.93C10.164 19.997 3 16.418 3 12a9 9 0 1118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Email</h4>
                    <p class="text-gray-600">support@gocarrent.com</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="text-blue-600 mb-4">
                        <svg class="mx-auto h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75C3.7 5.3 6.5 5.3 7.95 6.75L9 7.8m6 6l1.05 1.05c1.45 1.45 1.45 4.25 0 5.7a3.93 3.93 0 01-5.7 0l-9-9a3.93 3.93 0 010-5.7c1.45-1.45 4.25-1.45 5.7 0L15 13.8z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Telepon</h4>
                    <p class="text-gray-600">+62 812-3456-7890</p>
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
