<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Tampilkan form tambah mobil.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Simpan data mobil baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'transmission' => 'required|in:manual,automatic',
            'price_per_day' => 'required|numeric|min:0',
            'availability_status' => 'required|in:available,rented,maintenance',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'fuel_type' => 'required|string|max:50',
        ]);


        // Upload gambar
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->storeAs('cars', $request->file('image_url')->getClientOriginalName(), 'public');
            $validated['image_url'] = $path;
        }

        Car::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Car successfully added!');
    }

    public function index(Request $request)
    {
        $query = Car::query();

        // Search by brand, model, or year
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'ILIKE', "%{$search}%")
                    ->orWhere('model', 'ILIKE', "%{$search}%")
                    ->orWhere('year', 'LIKE', "%{$search}%");
            });
        }

        // Filter by availability_status
        if ($request->filled('status')) {
            $query->where('availability_status', $request->status);
        }

        $cars = $query->latest()->paginate(10)->withQueryString();

        return view('admin.index', compact('cars'));
    }


    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'transmission' => 'required|in:automatic,manual',
            'price_per_day' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'availability_status' => 'required|in:available,rented,maintenance',
            'image_url' => 'nullable|image|max:2048',
        ]);

        $car = Car::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('image_url')) {
            if ($car->image_url && Storage::disk('public')->exists($car->image_url)) {
                Storage::disk('public')->delete($car->image_url);
            }

            $imagePath = $request->file('image_url')->store('cars', 'public');
            $car->image_url = $imagePath;
        }

        $car->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'transmission' => $request->transmission,
            'price_per_day' => $request->price_per_day,
            'availability_status' => $request->availability_status,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Hapus gambar jika ada
        if ($car->image_url && Storage::disk('public')->exists($car->image_url)) {
            Storage::disk('public')->delete($car->image_url);
        }

        $car->delete();

        return redirect()->route('admin.index')->with('success', 'Mobil berhasil dihapus.');
    }
}
