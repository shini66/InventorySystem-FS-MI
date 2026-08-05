<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->when(request('category'), fn ($q, $c) => $q->where('category', $c))
            ->when(request('search'), fn ($q, $s) => $q->where('name', 'like', '%'.$s.'%'))
            ->latest()->paginate(10);

        return view('products.index', compact('products'));

    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'required|string|max:100',
        ]);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product Create');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku,'.$product->id,
            'category' => 'required|string|max:100',
        ]);

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product Update');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product Delete');
    }
}
