<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MovementController extends Controller
{
    public function index()
    {
        $movements = Movement::with('product')
            ->when(request('type'), fn($q, $t) => $q->where('type', $t))
            ->latest('date')->paginate(15);

        return view('movements.index', compact('movements'));

    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return  view('movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:entry,exit',
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
            'supplier' => 'nullable|string',
            'reason' => 'nullable|string',
            'date' => 'required|date'
        ]);

        DB::transaction(function () use ($data) {

            $product = Product::findOrFail($data['product_id']);

            if ($data['type'] === 'exit' && $product->stock < $data['quantity']) {
                throw ValidationException::withMessages(['quantity' => 'Insufficient Stock']);
            }

            Movement::create($data);

            $product->stock += $data['type'] === 'entry'
                ? $data['quantity']
                : -$data['quantity'];

            $product->save();
        });

        return redirect()->route('movements.index')->with('success', 'Movement Register');
    }

}
