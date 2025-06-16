x<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fas fa-car mr-2"></i>{{ $car->brand }} {{ $car->model }}
            </h2>
            <a href="{{ route('customer.cars.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Car Image and Details -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <!-- Car Image -->
                        <div class="h-64 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mb-6 relative">
                            @if($car->image_url)
                                <img src="{{ Storage::url($car->image_url) }}" 
                                     alt="{{ $car->brand }} {{ $car->model }}"
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <span class="text-white text-2xl font-bold">{{ $car->brand }} {{ $car->model }}</span>
                            @endif
                            
                            <!-- Availability Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium shadow-lg">
                                    <i class="fas fa-check-circle mr-1"></i>Tersedia
                                </span>
                            </div>
                        </div>

                        <!-- Car Specifications -->
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $car->brand }} {{ $car->model }}
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-300 flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>Tahun
                                    </span>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $car->year }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-300 flex items-center">
                                        <i class="fas fa-cogs mr-2"></i>Transmisi
                                    </span>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($car->transmission) }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-300 flex items-center">
                                        <i class="fas fa-users mr-2"></i>Kapasitas
                                    </span>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $car->capacity }} orang</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-300 flex items-center">
                                        <i class="fas fa-gas-pump mr-2"></i>Bahan Bakar
                                    </span>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($car->fuel_type) }}</p>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <span class="text-blue-600 dark:text-blue-300 text-sm flex items-center">
                                    <i class="fas fa-money-bill-wave mr-2"></i>Harga Sewa
                                </span>
                                <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">
                                    Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                    <span class="text-sm font-normal">/hari</span>
                                </p>
                            </div>

                            <!-- Description -->
                            @if($car->description)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>Deskripsi
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-300">{{ $car->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-calendar-plus mr-2"></i>Pesan Mobil Ini
                        </h3>
                        
                        <!-- Calendar Legend -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Keterangan:</h4>
                            <div class="flex flex-wrap gap-4 text-sm">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                                    <span class="text-gray-600 dark:text-gray-300">Tersedia</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                                    <span class="text-gray-600 dark:text-gray-300">Tidak Tersedia</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                                    <span class="text-gray-600 dark:text-gray-300">Dipilih</span>
                                </div>
                            </div>
                        </div>
                        
                        <form action="{{ route('customer.bookings.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            
                            <div class="space-y-4">
                                <!-- Start Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-calendar-alt mr-2"></i>Tanggal Mulai *
                                    </label>
                                    <input type="date" name="start_date" id="start_date" 
                                           min="{{ date('Y-m-d') }}" 
                                           value="{{ request('start_date') }}"
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Pilih tanggal mulai sewa</p>
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-calendar-check mr-2"></i>Tanggal Selesai *
                                    </label>
                                    <input type="date" name="end_date" id="end_date" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                           value="{{ request('end_date') }}"
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Pilih tanggal selesai sewa</p>
                                </div>

                                <!-- Date Range Validation Message -->
                                <div id="dateValidationMessage" class="hidden">
                                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <span id="validationText"></span>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-sticky-note mr-2"></i>Catatan (Opsional)
                                    </label>
                                    <textarea name="notes" rows="3" 
                                              placeholder="Tambahkan catatan khusus untuk pemesanan Anda..."
                                              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                <!-- Price Calculation -->
                                <div id="priceCalculation" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg hidden">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <i class="fas fa-calculator mr-2"></i>Rincian Harga
                                    </h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Durasi sewa</span>
                                            <span id="duration" class="font-medium text-gray-900 dark:text-white">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Harga per hari</span>
                                            <span id="pricePerDay" class="font-medium text-gray-900 dark:text-white">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Subtotal</span>
                                            <span id="subtotal" class="font-medium text-gray-900 dark:text-white">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-300">Pajak (10%)</span>
                                            <span id="tax" class="font-medium text-gray-900 dark:text-white">-</span>
                                        </div>
                                        <hr class="border-gray-300 dark:border-gray-600">
                                        <div class="flex justify-between text-lg font-bold">
                                            <span class="text-gray-900 dark:text-white">Total Bayar</span>
                                            <span id="total" class="text-blue-600 dark:text-blue-400">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Availability Status -->
                                <div id="availabilityStatus" class="hidden">
                                    <div id="availableMessage" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg hidden">
                                        <i class="fas fa-check-circle mr-2"></i>Mobil tersedia untuk tanggal yang dipilih
                                    </div>
                                    <div id="unavailableMessage" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg hidden">
                                        <i class="fas fa-times-circle mr-2"></i>Mobil tidak tersedia untuk tanggal yang dipilih
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" id="submitButton" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center"
                                        disabled>
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    <span id="submitText">Pesan Sekarang</span>
                                    <div class="ml-2 hidden" id="submitLoader">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass data to JavaScript -->
    <script>
        // Pass booked dates and availability calendar to JavaScript
        const bookedDates = @json(array_keys(array_filter($availabilityCalendar, function($available) { return !$available; })));
        const availabilityCalendar = @json($availabilityCalendar);
        const carId = {{ $car->id }};
    </script>

    <!-- Enhanced JavaScript for Date Restrictions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const submitButton = document.getElementById('submitButton');
            const submitText = document.getElementById('submitText');
            const submitLoader = document.getElementById('submitLoader');
            const priceCalculation = document.getElementById('priceCalculation');
            const availabilityStatus = document.getElementById('availabilityStatus');
            const dateValidationMessage = document.getElementById('dateValidationMessage');
            const validationText = document.getElementById('validationText');

            // Disable booked dates in date inputs
            function restrictBookedDates() {
                // Add event listener to validate date selection
                startDateInput.addEventListener('input', function() {
                    validateDateSelection(this.value, 'start');
                });

                endDateInput.addEventListener('input', function() {
                    validateDateSelection(this.value, 'end');
                });
            }

            // Validate if selected date is available
            function validateDateSelection(selectedDate, type) {
                if (!selectedDate) return;

                const isBooked = bookedDates.includes(selectedDate);
                
                if (isBooked) {
                    dateValidationMessage.classList.remove('hidden');
                    if (type === 'start') {
                        validationText.textContent = 'Tanggal mulai yang dipilih tidak tersedia. Silakan pilih tanggal lain.';
                        startDateInput.value = '';
                    } else {
                        validationText.textContent = 'Tanggal selesai yang dipilih tidak tersedia. Silakan pilih tanggal lain.';
                        endDateInput.value = '';
                    }
                    submitButton.disabled = true;
                    return false;
                } else {
                    dateValidationMessage.classList.add('hidden');
                    return true;
                }
            }

            // Check if date range contains any booked dates
            function isDateRangeAvailable(startDate, endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                for (let date = new Date(start); date <= end; date.setDate(date.getDate() + 1)) {
                    const dateStr = date.toISOString().split('T')[0];
                    if (bookedDates.includes(dateStr)) {
                        return false;
                    }
                }
                return true;
            }

            function updatePriceAndAvailability() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                // Reset states
                priceCalculation.classList.add('hidden');
                availabilityStatus.classList.add('hidden');
                submitButton.disabled = true;
                submitText.textContent = 'Pesan Sekarang';

                if (!startDate || !endDate) {
                    return;
                }

                // Validate individual dates first
                if (!validateDateSelection(startDate, 'start') || !validateDateSelection(endDate, 'end')) {
                    return;
                }

                // Update end date minimum
                const start = new Date(startDate);
                const minEnd = new Date(start);
                minEnd.setDate(minEnd.getDate() + 1);
                endDateInput.min = minEnd.toISOString().split('T')[0];

                // Check if end date is after start date
                if (new Date(endDate) <= new Date(startDate)) {
                    dateValidationMessage.classList.remove('hidden');
                    validationText.textContent = 'Tanggal selesai harus setelah tanggal mulai.';
                    return;
                }

                // Check if date range is available
                if (!isDateRangeAvailable(startDate, endDate)) {
                    dateValidationMessage.classList.remove('hidden');
                    validationText.textContent = 'Terdapat tanggal yang tidak tersedia dalam rentang waktu yang dipilih. Silakan pilih rentang waktu lain.';
                    return;
                }

                // All validations passed, hide validation message
                dateValidationMessage.classList.add('hidden');

                // Show loading state
                submitText.textContent = 'Menghitung harga...';
                submitLoader.classList.remove('hidden');

                // Fetch price calculation
                fetch('{{ route("customer.cars.calculate-price") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        car_id: carId,
                        start_date: startDate,
                        end_date: endDate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    submitLoader.classList.add('hidden');
                    
                    if (data.success) {
                        // Update price calculation
                        document.getElementById('duration').textContent = data.calculation.days + ' hari';
                        document.getElementById('pricePerDay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.calculation.price_per_day);
                        document.getElementById('subtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.calculation.subtotal);
                        document.getElementById('tax').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.calculation.tax);
                        document.getElementById('total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.calculation.total);
                        
                        priceCalculation.classList.remove('hidden');

                        // Update availability
                        const availableMessage = document.getElementById('availableMessage');
                        const unavailableMessage = document.getElementById('unavailableMessage');
                        
                        if (data.available) {
                            availableMessage.classList.remove('hidden');
                            unavailableMessage.classList.add('hidden');
                            submitButton.disabled = false;
                            submitText.textContent = 'Pesan Sekarang';
                        } else {
                            availableMessage.classList.add('hidden');
                            unavailableMessage.classList.remove('hidden');
                            submitButton.disabled = true;
                            submitText.textContent = 'Tidak Tersedia';
                        }
                        
                        availabilityStatus.classList.remove('hidden');
                    } else {
                        submitText.textContent = 'Pesan Sekarang';
                        alert('Terjadi kesalahan dalam perhitungan harga');
                    }
                })
                .catch(error => {
                    submitLoader.classList.add('hidden');
                    submitText.textContent = 'Pesan Sekarang';
                    console.error('Error:', error);
                    alert('Terjadi kesalahan dalam perhitungan harga');
                });
            }

            // Initialize
            restrictBookedDates();
            
            // Event listeners
            startDateInput.addEventListener('change', updatePriceAndAvailability);
            endDateInput.addEventListener('change', updatePriceAndAvailability);

            // Initial calculation if dates are pre-filled
            if (startDateInput.value && endDateInput.value) {
                updatePriceAndAvailability();
            }

            // Form submission handler
            document.getElementById('bookingForm').addEventListener('submit', function() {
                submitText.textContent = 'Memproses...';
                submitLoader.classList.remove('hidden');
                submitButton.disabled = true;
            });
        });
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>