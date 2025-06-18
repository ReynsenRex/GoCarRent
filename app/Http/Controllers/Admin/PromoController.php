<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.addPromo'); // sesuai lokasi file view kamu
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:promos,code',
            'description' => 'nullable|string',
            'discount_pct' => 'required|numeric|min:1|max:100',
        ]);

        Promo::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Promo berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        return view('admin.promos.show', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo)
    {
        return view('admin.editPromo', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('promos')->ignore($promo->id),
            ],
            'description' => 'nullable|string',
            'discount_pct' => 'required|numeric|min:0|max:100',
        ]);

        $promo->update($validated);

        return redirect()->route('admin.dashboard')
                        ->with('success', 'Promo updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.dashboard')
                        ->with('success', 'Promo deleted successfully!');
    }
}