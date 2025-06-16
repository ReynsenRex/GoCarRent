<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>

            <div class="flex space-x-2 items-center">
                <!-- Tombol Menuju admin/create -->
                <a href="{{ route('admin.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                    + Add New Car
                </a>

                <a href="{{ route('admin.statistics') }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                    Laporan
                </a>

                <a href="{{ route('admin.index') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    Manage Cars
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
            <!-- Total Pemesanan -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-blue-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">
                            Total Pemesanan
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($stats['total_bookings'] ?? 0) }}
                        </p>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-yellow-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wide mb-1">
                            Pending
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($stats['pending_bookings'] ?? 0) }}
                        </p>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Disetujui -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">
                            Disetujui
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($stats['approved_bookings'] ?? 0) }}
                        </p>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-cyan-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-cyan-600 uppercase tracking-wide mb-1">
                            Selesai
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($stats['completed_bookings'] ?? 0) }}
                        </p>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ditolak -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-red-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-red-600 uppercase tracking-wide mb-1">
                            Ditolak
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($stats['rejected_bookings'] ?? 0) }}
                        </p>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Dibatalkan -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-gray-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">
                            Dibatalkan
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($stats['cancelled_bookings'] ?? 0) }}
                        </p>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue and Chart Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Revenue Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">
                                Total Pendapatan
                            </p>
                            <p class="text-2xl font-bold text-gray-800">
                                Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="text-gray-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bestseller Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md border-l-4 border-green-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">
                                Mobil Terlaris
                            </p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $stats['top_car']['brand'] ?? 'Tidak ada data' }}
                                {{ $stats['top_car']['model'] ?? '' }}
                            </p>
                        </div>
                        <div class="text-gray-300">

                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960"
                                width="32px" fill="currentColor">
                                <path
                                    d="M240-200v40q0 17-11.5 28.5T200-120h-40q-17 0-28.5-11.5T120-160v-320l84-240q6-18 21.5-29t34.5-11h440q19 0 34.5 11t21.5 29l84 240v320q0 17-11.5 28.5T800-120h-40q-17 0-28.5-11.5T720-160v-40H240Zm-8-360h496l-42-120H274l-42 120Zm-32 80v200-200Zm100 160q25 0 42.5-17.5T360-380q0-25-17.5-42.5T300-440q-25 0-42.5 17.5T240-380q0 25 17.5 42.5T300-320Zm360 0q25 0 42.5-17.5T720-380q0-25-17.5-42.5T660-440q-25 0-42.5 17.5T600-380q0 25 17.5 42.5T660-320Zm-460 40h560v-200H200v200Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Monthly Chart -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Pemesanan per Bulan ({{ date('Y') }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="relative" style="height: 320px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Monthly Income Chart -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Pendapatan per bulan ({{ date('Y') }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="relative" style="height: 320px;">
                            <canvas id="monthlyIncomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Pemesanan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mobil</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings ?? [] as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->car->brand }} {{ $booking->car->model }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->start_date instanceof \Carbon\Carbon ? $booking->start_date->format('d/m/Y') : $booking->start_date }}
                                    -
                                    {{ $booking->end_date instanceof \Carbon\Carbon ? $booking->end_date->format('d/m/Y') : $booking->end_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                    {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($booking->status)
                                        @case('pending')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @break

                                        @case('approved')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @break

                                        @case('rejected')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @break

                                        @case('completed')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>
                                        @break

                                        @case('cancelled')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Dibatalkan</span>
                                        @break

                                        @case('in_progress')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Sedang
                                                Berjalan</span>
                                        @break

                                        @default
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($booking->status) }}</span>
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data
                                        pemesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart.js Script -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if canvas element exists
                const canvas = document.getElementById('monthlyChart');
                const incomeCanvas = document.getElementById('monthlyIncomeChart');
                if (!canvas && !incomeCanvas) {
                    console.error('Canvas element not found');
                    return;
                }

                // Get context
                const ctx = canvas.getContext('2d');
                const incomeCtx = incomeCanvas.getContext('2d');
                if (!ctx && !incomeCtx) {
                    console.error('Cannot get canvas context');
                    return;
                }

                // Month names
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                // Prepare data for chart
                const monthlyData = @json($stats['monthly_bookings'] ?? []);
                const monthlyIncomeData = @json($stats['monthly_income_bookings'] ?? []);
                console.log('Monthly Income Data:', monthlyIncomeData);
                console.log('Monthly Data:', monthlyData);

                const chartData = [];
                const chartLabels = [];

                const incomeChartData = [];
                const incomeChartLabels = [];

                // Build chart data
                for (let i = 1; i <= 12; i++) {
                    chartLabels.push(monthNames[i - 1]);
                    chartData.push(monthlyData[i] || 0);
                    incomeChartLabels.push(monthNames[i - 1]);
                    incomeChartData.push(monthlyIncomeData[i] || 0);
                }

                console.log('Chart Labels:', chartLabels);
                console.log('Chart Data:', chartData);
                console.log('Income Chart Labels:', incomeChartLabels);
                console.log('Income Chart Data:', incomeChartData);

                // Create chart
                try {
                    const monthlyChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Jumlah Pemesanan',
                                data: chartData,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#3B82F6',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointHoverBackgroundColor: '#1D4ED8',
                                pointHoverBorderColor: '#ffffff',
                                pointHoverBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        color: '#374151',
                                        usePointStyle: true,
                                        padding: 20,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#3B82F6',
                                    borderWidth: 1,
                                    cornerRadius: 6,
                                    displayColors: false,
                                    callbacks: {
                                        title: function(context) {
                                            return `Bulan ${context[0].label}`;
                                        },
                                        label: function(context) {
                                            return `Pemesanan: ${context.parsed.y}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Bulan',
                                        color: '#6B7280',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    },
                                    ticks: {
                                        color: '#6B7280',
                                        font: {
                                            size: 11
                                        }
                                    },
                                    grid: {
                                        color: '#F3F4F6',
                                        lineWidth: 1
                                    }
                                },
                                y: {
                                    display: true,
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Pemesanan',
                                        color: '#6B7280',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        color: '#6B7280',
                                        font: {
                                            size: 11
                                        },
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : '';
                                        }
                                    },
                                    grid: {
                                        color: '#F3F4F6',
                                        lineWidth: 1
                                    }
                                }
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });
                    const monthlyIncomeChart = new Chart(incomeCtx, {
                        type: 'line',
                        data: {
                            labels: incomeChartLabels,
                            datasets: [{
                                label: 'Jumlah Pendapatan',
                                data: incomeChartData,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#3B82F6',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointHoverBackgroundColor: '#1D4ED8',
                                pointHoverBorderColor: '#ffffff',
                                pointHoverBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        color: '#374151',
                                        usePointStyle: true,
                                        padding: 20,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#3B82F6',
                                    borderWidth: 1,
                                    cornerRadius: 6,
                                    displayColors: false,
                                    callbacks: {
                                        title: function(context) {
                                            return `Bulan ${context[0].label}`;
                                        },
                                        label: function(context) {
                                            return `Pendapatan: ${context.parsed.y}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Bulan',
                                        color: '#6B7280',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    },
                                    ticks: {
                                        color: '#6B7280',
                                        font: {
                                            size: 11
                                        }
                                    },
                                    grid: {
                                        color: '#F3F4F6',
                                        lineWidth: 1
                                    }
                                },
                                y: {
                                    display: true,
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Pendapatan',
                                        color: '#6B7280',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        color: '#6B7280',
                                        font: {
                                            size: 11
                                        },
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : '';
                                        }
                                    },
                                    grid: {
                                        color: '#F3F4F6',
                                        lineWidth: 1
                                    }
                                }
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });

                    console.log('Chart created successfully:', monthlyChart);
                    console.log('Income Chart created successfully:', monthlyIncomeChart);
                } catch (error) {
                    console.error('Error creating chart:', error);
                }
            });
        </script>
    </x-app-layout>
