<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $productsQuery = Product::where('user_id', Auth::id());;

        $this->applySearch($productsQuery, $request->search);

        if ($request->has('category_id') && $request->category_id != '') {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->get();

        $categories = Category::all();

        return inertia('Frontend/Product/Index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->category_id,
        ]);
    }

    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return inertia('Frontend/Product/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
           $image = $request->file('image')->store('images', 'public');

        }
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image',
        ]);

        Product::create([
            'user_id' => Auth::id(), 
            'description' => $request->description,
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $request->image->hashName(),
        ]);

        return redirect()->to('/products')->with('message', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        return inertia('Frontend/Product/Show', ['product' => $product->load('category')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return inertia('Frontend/Product/Edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow image but not required
        ]);
    
        $image = $product->image;
    
        if ($request->hasFile('image')) {
            Log::info('New image uploaded:', ['file' => $request->file('image')->getClientOriginalName()]);
    
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
    
            $image = $request->file('image')->hashName();
            $request->file('image')->store('images', 'public');
        }
    
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $image,
        ]);
    
        Log::info('Product updated successfully:', ['product' => $product]);
    
        return redirect()->to('/products')->with('message', 'Product updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->to('/products')->with('message', 'Product deleted successfully.');
    }
}
