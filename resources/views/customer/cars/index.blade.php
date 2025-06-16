<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 -mx-6 -mt-6 px-6 pt-6 pb-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            <i class="fas fa-search mr-3"></i>Cari Mobil Impian
                        </h2>
                        <p class="text-blue-100 mt-2 text-lg">Temukan kendaraan yang sesuai dengan kebutuhan Anda</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ $cars->total() }}</div>
                            <div class="text-blue-100 text-sm">Mobil Tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Enhanced Search Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-xl mb-8 border border-gray-100 dark:border-gray-700">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-filter mr-2 text-blue-600"></i>
                        Filter Pencarian
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sesuaikan pencarian untuk hasil yang lebih akurat</p>
                </div>
                
                <div class="p-6">
                    <form method="GET" action="{{ route('customer.cars.index') }}" id="searchForm" class="space-y-6">
                        
                        <!-- Primary Search Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Location -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas fa-map-marker-alt text-white text-sm"></i>
                                    </div>
                                    Lokasi Pengambilan
                                </label>
                                <select name="location" id="location" class="w-full p-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-300 group-hover:border-blue-300">
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($filterOptions['locations'] as $location)
                                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                            <i class="fas fa-map-marker-alt mr-2"></i>{{ ucfirst($location) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas fa-calendar-alt text-white text-sm"></i>
                                    </div>
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full p-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-300 group-hover:border-blue-300">
                            </div>

                            <!-- End Date -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas fa-calendar-check text-white text-sm"></i>
                                    </div>
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full p-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-300 group-hover:border-blue-300">
                            </div>
                        </div>

                        <!-- Advanced Filters Toggle -->
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                            <button type="button" id="toggleAdvanced" class="group flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900 px-4 py-2 rounded-lg">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-sliders-h text-white text-sm"></i>
                                </div>
                                <span>Filter Lanjutan</span>
                                <i class="fas fa-chevron-down ml-3 transform transition-transform duration-200 group-hover:scale-110" id="toggleIcon"></i>
                            </button>
                        </div>

                        <!-- Advanced Filters (Hidden by default) -->
                        <div id="advancedFilters" class="hidden space-y-6 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900 p-6 rounded-xl border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Brand -->
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-md flex items-center justify-center mr-2">
                                            <i class="fas fa-car text-white text-xs"></i>
                                        </div>
                                        Merek Mobil
                                    </label>
                                    <select name="brand" id="brand" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Semua Merek</option>
                                        @foreach($filterOptions['brands'] as $brand)
                                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                                {{ $brand }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Transmission -->
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-orange-600 rounded-md flex items-center justify-center mr-2">
                                            <i class="fas fa-cogs text-white text-xs"></i>
                                        </div>
                                        Transmisi
                                    </label>
                                    <select name="transmission" id="transmission" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Semua Transmisi</option>
                                        @foreach($filterOptions['transmissions'] as $transmission)
                                            <option value="{{ $transmission }}" {{ request('transmission') == $transmission ? 'selected' : '' }}>
                                                {{ ucfirst($transmission) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Fuel Type -->
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-md flex items-center justify-center mr-2">
                                            <i class="fas fa-gas-pump text-white text-xs"></i>
                                        </div>
                                        Bahan Bakar
                                    </label>
                                    <select name="fuel_type" id="fuel_type" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Semua Jenis</option>
                                        @foreach($filterOptions['fuel_types'] as $fuelType)
                                            <option value="{{ $fuelType }}" {{ request('fuel_type') == $fuelType ? 'selected' : '' }}>
                                                {{ ucfirst($fuelType) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Capacity -->
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-teal-500 to-teal-600 rounded-md flex items-center justify-center mr-2">
                                            <i class="fas fa-users text-white text-xs"></i>
                                        </div>
                                        Kapasitas
                                    </label>
                                    <select name="capacity" id="capacity" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Semua Kapasitas</option>
                                        <option value="2" {{ request('capacity') == '2' ? 'selected' : '' }}>2+ orang</option>
                                        <option value="4" {{ request('capacity') == '4' ? 'selected' : '' }}>4+ orang</option>
                                        <option value="6" {{ request('capacity') == '6' ? 'selected' : '' }}>6+ orang</option>
                                        <option value="8" {{ request('capacity') == '8' ? 'selected' : '' }}>8+ orang</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-md flex items-center justify-center mr-2">
                                            <i class="fas fa-money-bill-wave text-white text-xs"></i>
                                        </div>
                                        Harga Minimum (per hari)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                                               placeholder="100,000"
                                               class="w-full pl-12 pr-4 p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-md flex items-center justify-center mr-2">
                                            <i class="fas fa-money-bill-wave text-white text-xs"></i>
                                        </div>
                                        Harga Maksimum (per hari)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                                               placeholder="1,000,000"
                                               class="w-full pl-12 pr-4 p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search and Reset Buttons -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 bg-blue-50 dark:bg-blue-900 px-4 py-2 rounded-lg">
                                <i class="fas fa-magic text-blue-600"></i>
                                <span>Filter otomatis diterapkan saat Anda melakukan perubahan</span>
                            </div>
                            
                            <div class="flex space-x-4">
                                <!-- Reset Button -->
                                <a href="{{ route('customer.cars.index') }}" 
                                   class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-undo mr-2"></i>
                                    Reset Filter
                                </a>
                                
                                <!-- Search Button -->
                                <button type="submit" id="searchButton" 
                                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-search mr-2"></i>
                                    <span>Cari Mobil</span>
                                    <div class="ml-2 hidden" id="searchLoader">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Search Results Info -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 mb-8 border border-blue-100 dark:border-gray-600 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-search text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                @if(request()->hasAny(['location', 'start_date', 'end_date', 'brand', 'transmission', 'fuel_type', 'capacity', 'min_price', 'max_price']))
                                    Hasil Pencarian dengan Filter
                                @else
                                    Semua Mobil Tersedia
                                @endif
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Ditemukan {{ $cars->total() }} mobil yang sesuai</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-full font-bold text-lg shadow-lg">
                        {{ $cars->total() }}
                    </div>
                </div>
                
                @if(request()->hasAny(['location', 'start_date', 'end_date', 'brand', 'transmission', 'fuel_type', 'capacity', 'min_price', 'max_price']))
                    <div class="flex flex-wrap gap-2">
                        @if(request('location'))
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ ucfirst(request('location')) }}
                            </span>
                        @endif
                        @if(request('start_date'))
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime(request('start_date'))) }}
                            </span>
                        @endif
                        @if(request('end_date'))
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-calendar-check mr-1"></i>{{ date('d M Y', strtotime(request('end_date'))) }}
                            </span>
                        @endif
                        @if(request('brand'))
                            <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-car mr-1"></i>{{ request('brand') }}
                            </span>
                        @endif
                        @if(request('transmission'))
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-cogs mr-1"></i>{{ ucfirst(request('transmission')) }}
                            </span>
                        @endif
                        @if(request('fuel_type'))
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-gas-pump mr-1"></i>{{ ucfirst(request('fuel_type')) }}
                            </span>
                        @endif
                        @if(request('capacity'))
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-users mr-1"></i>{{ request('capacity') }}+ orang
                            </span>
                        @endif
                        @if(request('min_price') || request('max_price'))
                            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-money-bill-wave mr-1"></i>
                                @if(request('min_price') && request('max_price'))
                                    Rp {{ number_format(request('min_price'), 0, ',', '.') }} - {{ number_format(request('max_price'), 0, ',', '.') }}
                                @elseif(request('min_price'))
                                    Min Rp {{ number_format(request('min_price'), 0, ',', '.') }}
                                @else
                                    Max Rp {{ number_format(request('max_price'), 0, ',', '.') }}
                                @endif
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Enhanced Results Grid -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    @if($cars->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                            @foreach($cars as $car)
                                <div class="bg-white dark:bg-gray-700 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-gray-100 dark:border-gray-600 group">
                                    <!-- Car Image -->
                                    <div class="h-48 bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 flex items-center justify-center relative overflow-hidden">
                                        @if($car->image_url)
                                            <img src="{{ Storage::url($car->image_url) }}" 
                                                 alt="{{ $car->brand }} {{ $car->model }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="text-center">
                                                <i class="fas fa-car text-white text-4xl mb-2"></i>
                                                <span class="text-white text-lg font-bold block">{{ $car->brand }}</span>
                                                <span class="text-blue-100 text-sm">{{ $car->model }}</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Availability Badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-gradient-to-r from-green-500 to-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg flex items-center">
                                                <i class="fas fa-check-circle mr-1"></i>Tersedia
                                            </span>
                                        </div>

                                        <!-- Car Type Badge -->
                                        <div class="absolute bottom-3 left-3">
                                            <span class="bg-black/20 backdrop-blur-sm text-white px-2 py-1 rounded text-xs font-medium">
                                                {{ $car->year }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Car Details -->
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">
                                                {{ $car->brand }}
                                            </h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ $car->model }}</span>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-600 dark:text-gray-300 mb-4">
                                            <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                <i class="fas fa-cogs w-4 mr-2 text-blue-600"></i>
                                                <span class="font-medium">{{ ucfirst($car->transmission) }}</span>
                                            </div>
                                            <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                <i class="fas fa-users w-4 mr-2 text-green-600"></i>
                                                <span class="font-medium">{{ $car->capacity }} orang</span>
                                            </div>
                                            <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                <i class="fas fa-gas-pump w-4 mr-2 text-orange-600"></i>
                                                <span class="font-medium">{{ ucfirst($car->fuel_type) }}</span>
                                            </div>
                                            <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                <i class="fas fa-calendar-alt w-4 mr-2 text-purple-600"></i>
                                                <span class="font-medium">{{ $car->year }}</span>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 p-4 rounded-xl mb-4 border border-blue-100 dark:border-blue-800">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="text-blue-600 dark:text-blue-300 text-sm font-medium">Harga Sewa</span>
                                                    <div class="flex items-baseline">
                                                        <span class="text-3xl font-bold text-blue-700 dark:text-blue-300">
                                                            Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                                        </span>
                                                        <span class="text-blue-500 text-sm ml-1">/hari</span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-tag text-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        <a href="{{ route('customer.cars.show', $car->id) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                                           class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-4 rounded-xl font-semibold transition-all duration-200 inline-block text-center hover:shadow-xl transform hover:-translate-y-1 group">
                                            <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                            Lihat Detail & Pesan
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Enhanced Pagination -->
                        <div class="mt-12 flex justify-center">
                            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-4 border border-gray-200 dark:border-gray-600">
                                {{ $cars->withQueryString()->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-20">
                            <div class="mb-8">
                                <div class="w-32 h-32 mx-auto bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-6">
                                    <i class="fas fa-car-crash text-gray-400 text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tidak Ada Mobil Ditemukan</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                                    Maaf, tidak ada mobil yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau reset pencarian.
                                </p>
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <a href="{{ route('customer.cars.index') }}" 
                                       class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 inline-flex items-center shadow-lg hover:shadow-xl">
                                        <i class="fas fa-undo mr-2"></i>Reset Pencarian
                                    </a>
                                    <a href="{{ route('customer.dashboard') }}" 
                                       class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 inline-flex items-center shadow-lg hover:shadow-xl">
                                        <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Advanced filters toggle with animation
            const toggleAdvanced = document.getElementById('toggleAdvanced');
            const advancedFilters = document.getElementById('advancedFilters');
            const toggleIcon = document.getElementById('toggleIcon');

            toggleAdvanced.addEventListener('click', function() {
                advancedFilters.classList.toggle('hidden');
                toggleIcon.classList.toggle('rotate-180');
                
                // Add slide animation
                if (!advancedFilters.classList.contains('hidden')) {
                    advancedFilters.style.maxHeight = '0px';
                    advancedFilters.style.overflow = 'hidden';
                    setTimeout(() => {
                        advancedFilters.style.maxHeight = advancedFilters.scrollHeight + 'px';
                        advancedFilters.style.transition = 'max-height 0.3s ease-in-out';
                    }, 10);
                }
            });

            // Auto-search functionality with better UX
            let searchTimeout;
            const searchForm = document.getElementById('searchForm');
            const searchButton = document.getElementById('searchButton');
            const searchLoader = document.getElementById('searchLoader');
            
            // Form inputs that trigger auto-search
            const autoSearchInputs = [
                'location', 'start_date', 'end_date', 'brand', 
                'transmission', 'fuel_type', 'capacity'
            ];

            // Add event listeners to auto-search inputs
            autoSearchInputs.forEach(inputName => {
                const input = document.getElementById(inputName);
                if (input) {
                    input.addEventListener('change', function() {
                        // Visual feedback
                        this.style.borderColor = '#3B82F6';
                        this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
                        
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            showSearchLoader();
                            searchForm.submit();
                        }, 800);
                    });

                    // Reset visual feedback
                    input.addEventListener('blur', function() {
                        setTimeout(() => {
                            this.style.borderColor = '';
                            this.style.boxShadow = '';
                        }, 2000);
                    });
                }
            });

            // Price inputs with debounce and formatting
            const priceInputs = ['min_price', 'max_price'];
            priceInputs.forEach(inputName => {
                const input = document.getElementById(inputName);
                if (input) {
                    input.addEventListener('input', function() {
                        // Format number display (optional)
                        let value = this.value.replace(/\D/g, '');
                        if (value) {
                            // Visual feedback for typing
                            this.style.borderColor = '#10B981';
                        }
                        
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            if (this.value) {
                                showSearchLoader();
                                searchForm.submit();
                            }
                        }, 2000); // Longer delay for price inputs
                    });
                }
            });

            // Enhanced date handling
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', function() {
                    const startDate = new Date(this.value);
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(minEndDate.getDate() + 1);
                    endDateInput.min = minEndDate.toISOString().split('T')[0];
                    
                    // Clear end date if it's before the new minimum
                    if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                        endDateInput.value = '';
                        // Show helpful message
                        showDateMessage('Tanggal selesai telah direset karena tidak valid');
                    }
                });
            }

            // Enhanced search loader
            function showSearchLoader() {
                const originalText = searchButton.querySelector('span').textContent;
                searchButton.querySelector('span').textContent = 'Mencari...';
                searchLoader.classList.remove('hidden');
                searchButton.disabled = true;
                searchButton.classList.add('opacity-75');
                
                // Add pulsing effect
                searchButton.classList.add('animate-pulse');
            }

            // Show date validation message
            function showDateMessage(message) {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
                messageDiv.innerHTML = `<i class="fas fa-info-circle mr-2"></i>${message}`;
                document.body.appendChild(messageDiv);
                
                setTimeout(() => {
                    messageDiv.classList.add('opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(messageDiv);
                    }, 300);
                }, 3000);
            }

            // Manual search button with enhanced feedback
            searchForm.addEventListener('submit', function(e) {
                showSearchLoader();
                
                // Show loading overlay for better UX
                const overlay = document.createElement('div');
                overlay.className = 'fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50';
                overlay.innerHTML = `
                    <div class="bg-white rounded-lg p-6 shadow-xl">
                        <div class="flex items-center">
                            <i class="fas fa-spinner fa-spin text-blue-600 text-2xl mr-3"></i>
                            <span class="text-lg font-medium">Mencari mobil...</span>
                        </div>
                    </div>
                `;
                document.body.appendChild(overlay);
            });

            // Show advanced filters if any advanced filter is active
            const hasAdvancedFilters = [
                '{{ request("brand") }}',
                '{{ request("transmission") }}',
                '{{ request("fuel_type") }}',
                '{{ request("capacity") }}',
                '{{ request("min_price") }}',
                '{{ request("max_price") }}'
            ].some(value => value !== '');

            if (hasAdvancedFilters) {
                advancedFilters.classList.remove('hidden');
                toggleIcon.classList.add('rotate-180');
            }

            // Add smooth scroll to results when searching
            if (window.location.search) {
                setTimeout(() => {
                    document.querySelector('.bg-gradient-to-r.from-blue-50.to-indigo-50')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 500);
            }
        });
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>