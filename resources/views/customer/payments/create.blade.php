<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fas fa-credit-card mr-2"></i>Pembayaran
            </h2>
            <a href="{{ route('customer.bookings.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pemesanan
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Booking Summary -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pemesanan</h3>
                        
                        <!-- Car Info -->
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex-shrink-0">
                                @if($booking->car->image_url)
                                    <img src="{{ Storage::url($booking->car->image_url) }}" 
                                         alt="{{ $booking->car->brand }} {{ $booking->car->model }}"
                                         class="w-20 h-14 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-14 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">{{ $booking->car->brand }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $booking->car->brand }} {{ $booking->car->model }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $booking->car->year }} • {{ ucfirst($booking->car->transmission) }}
                                </p>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Booking ID:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Tanggal Sewa:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Durasi:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} hari
                                </span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Rincian Pembayaran</h4>
                            @php
                                $days = \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1;
                                $pricePerDay = $booking->car->price_per_day;
                                $subtotal = $days * $pricePerDay;
                                $tax = $subtotal * 0.1;
                            @endphp
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Sewa {{ $days }} hari @ Rp {{ number_format($pricePerDay, 0, ',', '.') }}:</span>
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
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-900 dark:text-white">Total Pembayaran:</span>
                                    <span class="text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Metode Pembayaran</h3>
                        
                        <!-- Payment Notice -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Pembayaran Otomatis:</strong> Setelah Anda memilih metode pembayaran dan mengklik "Proses Pembayaran", 
                                        transaksi akan langsung diproses dan status booking akan berubah menjadi "Sedang Berlangsung".
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <form action="{{ route('customer.payments.store', $booking->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                            @csrf
                            
                            <!-- Payment Method -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Pilih Metode Pembayaran
                                </label>
                                <div class="space-y-3">
                                    <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <input type="radio" id="cash" name="payment_method" value="cash" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                        <label for="cash" class="ml-3 flex items-center cursor-pointer">
                                            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Tunai</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Bayar di tempat pengambilan</div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="bank_transfer" class="ml-3 flex items-center cursor-pointer">
                                            <i class="fas fa-university text-blue-600 mr-2"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Transfer Bank</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">BCA, BNI, BRI, Mandiri</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <input type="radio" id="credit_card" name="payment_method" value="credit_card" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="credit_card" class="ml-3 flex items-center cursor-pointer">
                                            <i class="fas fa-credit-card text-purple-600 mr-2"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Kartu Kredit</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Visa, Mastercard</div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <input type="radio" id="debit_card" name="payment_method" value="debit_card" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="debit_card" class="ml-3 flex items-center cursor-pointer">
                                            <i class="fas fa-credit-card text-indigo-600 mr-2"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Kartu Debit</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">ATM/Debit Card</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <input type="radio" id="e_wallet" name="payment_method" value="e_wallet" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="e_wallet" class="ml-3 flex items-center cursor-pointer">
                                            <i class="fas fa-wallet text-orange-600 mr-2"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">E-Wallet</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">OVO, GoPay, DANA, ShopeePay</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Details (Dynamic) -->
                            <div id="payment_details" class="mb-6 hidden">
                                <!-- Bank Transfer Details -->
                                <div id="bank_transfer_details" class="payment-detail hidden">
                                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">Informasi Transfer Bank</h4>
                                        <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                                            <div><strong>Bank BCA:</strong> 1234567890 a.n. GoCarRent</div>
                                            <div><strong>Bank BNI:</strong> 0987654321 a.n. GoCarRent</div>
                                            <div><strong>Jumlah Transfer:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-Wallet Details -->
                                <div id="e_wallet_details" class="payment-detail hidden">
                                    <div class="bg-orange-50 dark:bg-orange-900 p-4 rounded-lg">
                                        <h4 class="font-semibold text-orange-900 dark:text-orange-100 mb-3">E-Wallet Payment</h4>
                                        <div class="space-y-2 text-sm text-orange-800 dark:text-orange-200">
                                            <div><strong>Scan QR Code</strong> atau transfer ke nomor yang akan diberikan setelah konfirmasi</div>
                                            <div><strong>Jumlah:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cash Details -->
                                <div id="cash_details" class="payment-detail hidden">
                                    <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-3">Pembayaran Tunai</h4>
                                        <div class="space-y-2 text-sm text-green-800 dark:text-green-200">
                                            <div><strong>Lokasi:</strong> Kantor GoCarRent</div>
                                            <div><strong>Alamat:</strong> Jl. Rental Mobil No. 123, Jakarta</div>
                                            <div><strong>Jam Operasional:</strong> 08:00 - 17:00 WIB</div>
                                            <div><strong>Jumlah:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Proof of Payment -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bukti Pembayaran (Opsional)
                                </label>
                                <input type="file" name="payment_proof" accept="image/*"
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Upload screenshot atau foto bukti pembayaran (JPG, PNG, max 2MB)</p>
                            </div>

                            <!-- Submit Button with Updated Text -->
                            <button type="submit" id="submitBtn"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <span id="submitText">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Bayar & Kembali ke Pemesanan
                                </span>
                                <div id="submitLoader" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Memproses Pembayaran...
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Payment Method Selection -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const paymentDetails = document.getElementById('payment_details');
            const paymentForm = document.getElementById('paymentForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoader = document.getElementById('submitLoader');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    // Hide all payment details
                    document.querySelectorAll('.payment-detail').forEach(detail => {
                        detail.classList.add('hidden');
                    });

                    // Show payment details container
                    paymentDetails.classList.remove('hidden');

                    // Show relevant details based on selected method
                    const selectedMethod = this.value;
                    const detailElement = document.getElementById(selectedMethod + '_details');
                    if (detailElement) {
                        detailElement.classList.remove('hidden');
                    }
                });
            });

            // Form submission handler
            paymentForm.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoader.classList.remove('hidden');

                // Optional: Add confirmation dialog for certain payment methods
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
                if (selectedMethod) {
                    const methodName = selectedMethod.nextElementSibling.querySelector('.text-sm').textContent;
                    
                    // You can add specific confirmations here if needed
                    console.log('Processing payment with method:', methodName);
                }
            });
        });
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>