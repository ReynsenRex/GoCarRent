<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;

class PromoController extends Controller
{
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

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan!');
    }
}