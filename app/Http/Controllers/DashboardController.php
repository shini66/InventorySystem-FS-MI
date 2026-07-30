<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $byCategory = Product::selectRaw('category, SUM(stock) as total')
            ->groupBy('category')->get();

        return view('dashboard', compact('totalProducts', 'totalStock', 'byCategory'));
    }
}
