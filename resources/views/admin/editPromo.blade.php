<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        {{-- Tombol Kembali --}}
        <a href="{{ route('admin.dashboard') }}"
            class="inline-block mb-4 text-blue-600 hover:text-blue-800 font-medium">
            ← Kembali
        </a>

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Promo</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.promos.store') }}" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Kode Promo</label>
                <input type="text" name="code" id="code" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div>
                <label for="discount_pct" class="block text-sm font-medium text-gray-700">Diskon (%)</label>
                <input type="number" name="discount_pct" id="discount_pct" required min="1" max="100"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition duration-200">
                    Simpan Promo
                </button>
            </div>
        </form>
    </div>
</x-app-layout>