<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $promos = Promo::all();
        return view('admin.dashboard', compact('promos'));
    }
}
