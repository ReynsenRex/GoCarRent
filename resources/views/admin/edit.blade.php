<x-app-layout>
    <div class="min-h-screen bg-white py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
        
            <div class="text-center mb-8 bg-blue-600 to -purple-600 rounded-2xl shadow-lg py-8 px-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-700 to-indigo-700 rounded-full mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-100 to-gray-400 bg-clip-text text-transparent mb-2">
                    Edit Car
                </h1>
                <p class="text-xl text-gray-300 font-medium">{{ $car->brand }} {{ $car->model }}</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-8 bg-red-900/30 border-l-4 border-red-600 rounded-lg shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-red-300 font-semibold">There are errors in the form:</h3>
                        </div>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-200 flex items-center">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-2"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Main Form -->
            <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Vehicle Form
                    </h2>
                    <p class="text-blue-100 mt-1">Update your vehicle information</p>
                </div>

                <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Brand -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Car Brand
                                </label>
                                <input type="text" name="brand" value="{{ old('brand', $car->brand) }}"
                                    class="w-full px-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400" 
                                    placeholder="e.g. Toyota, Honda, BMW" required>
                            </div>

                            <!-- Model -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Car Model
                                </label>
                                <input type="text" name="model" value="{{ old('model', $car->model) }}"
                                    class="w-full px-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400" 
                                    placeholder="e.g. Avanza, Civic, X3" required>
                            </div>

                            <!-- Year -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Production Year
                                </label>
                                <input type="number" name="year" value="{{ old('year', $car->year) }}" min="1900" max="2025"
                                    class="w-full px-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400" 
                                    placeholder="2020" required>
                            </div>

                    
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Capacity
                                </label>
                                <input type="number" name="capacity" min="1" max="20"
                                    value="{{ old('capacity', $car->capacity) }}"
                                    class="w-full px-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400"
                                    placeholder="Number of passengers" required>
                            </div>

                    

                            <!-- Transmission -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Transmission Type
                                </label>
                                <select name="transmission" class="w-full px-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400" required>
                                    <option value="">Select Transmission</option>
                                    <option value="automatic" {{ $car->transmission == 'automatic' ? 'selected' : '' }}>🔄 Automatic</option>
                                    <option value="manual" {{ $car->transmission == 'manual' ? 'selected' : '' }}>⚙️ Manual</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Price Per Day -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    Rental Price per Day
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-semibold">Rp</span>
                                    <input type="number" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" min="0"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400" 
                                        placeholder="300000" required>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">💡 Enter the price in Rupiah without dots or commas</p>
                            </div>  

                            <!-- Availability Status -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Availability Status
                                </label>
                                <select name="availability_status" class="w-full px-4 py-3 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-900 text-gray-100 focus:bg-gray-800 group-hover:border-blue-400" required>
                                    <option value="">Select Status</option>
                                    <option value="available" {{ $car->availability_status == 'available' ? 'selected' : '' }}>✅ Available</option>
                                    <option value="rented" {{ $car->availability_status == 'rented' ? 'selected' : '' }}>❌ Rented</option>
                                    <option value="maintenance" {{ $car->availability_status == 'maintenance' ? 'selected' : '' }}>❌ Maintenance</option>
                                </select>
                            </div>

                            
                            <!-- Image Upload -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Car Photo
                                </label>
                                <div class="border-2 border-dashed border-gray-700 rounded-xl p-6 hover:border-blue-500 transition-colors duration-200 bg-gray-900 hover:bg-gray-800">
                                    <input type="file" name="image_url" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-900 file:text-blue-300 hover:file:bg-blue-800 transition-all duration-200">
                                    <p class="text-xs text-gray-400 mt-2">📷 Supported formats: JPG, PNG, GIF (Max: 2MB)</p>
                                </div>
                                
                                @if ($car->image_url)
                                    <div class="mt-4 p-4 bg-gray-900 rounded-xl border border-gray-700">
                                        <p class="text-sm font-semibold text-gray-200 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Current Photo:
                                        </p>
                                        <div class="relative inline-block">
                                            <img src="{{ asset('storage/' . $car->image_url) }}" 
                                                 class="w-full max-w-sm h-48 object-cover rounded-lg shadow-md border-2 border-gray-800" 
                                                 alt="Current car image">
                                            <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-semibold">
                                                ✓ Active
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-10 pt-6 border-t border-gray-700">
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('admin.index') }}" 
                               class="px-6 py-3 border border-gray-600 text-gray-200 rounded-xl hover:bg-gray-700 font-semibold transition-all duration-200 text-center hover:shadow-md">
                                ↩️ Back
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-blue-700 to-indigo-700 text-white rounded-xl hover:from-blue-800 hover:to-indigo-800 font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Car
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            

            <!-- Additional Info Card -->
            <div class="mt-8 bg-gradient-to-r from-gray-800 to-gray-900 border border-blue-900 rounded-xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-blue-200 mb-1">💡 Tips for Updating Car:</h3>
                        <ul class="text-sm text-blue-300 space-y-1">
                            <li>• Make sure all information is correct before saving</li>
                            <li>• Car photos should be high quality and show the current condition</li>
                            <li>• Competitive rental prices will increase customer interest</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>