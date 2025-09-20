<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Notifications\LowStockNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch products with optional low stock filter and search and pagination
        $query = Product::query();

        // search by name or SKU
        if ($request->get('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // filter low stock
        if ($request->get('low_stock')) {
            $query->whereColumn('stock_quantity', '<=', 'reorder_level');
        }

        $products = $query->orderBy('name')->paginate(10);

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:110',
            'sku' => 'required|string|max:100|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        try {
            $product = Product::create($validated);
            if ($product->isLowStock()) {
                // notify admin about low stock 
                auth()->user()->notify(new LowStockNotification($product));

            }
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:110',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        try {

            $product->update($validated);

            if ($product->isLowStock()) {
                // notify admin about low stock 
               auth()->user()->notify(new LowStockNotification($product));

            }
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete product: ' . $e->getMessage()]);
        }
    }
}
