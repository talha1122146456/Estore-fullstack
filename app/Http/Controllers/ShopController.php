<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Added Category model
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get filter inputs
        $search = $request->input('search');
        $categoryId = $request->input('category');

        // 2. Start the query with 'category' eager loaded to prevent N+1 issues
        $query = Product::with('category');

        // 3. Filter by Search Term (Name or Description)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // 4. Filter by Category if selected
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // 5. Get results (Paginated is better for performance)
        $products = $query->latest()->get();
        $categories = Category::all(); // For the sidebar/dropdown

        // 6. Return to shop.index
        return view('shop.index', compact('products', 'categories', 'search'));
    }



    public function show(\App\Models\Product $product)
    {
        // This finds the product by ID and sends it to the detail view
        return view('shop.show', compact('product'));
    }



    public function trackOrder() {
        return view('shop.track');
    }
    
    public function searchOrder(Request $request) 
    {
        // Validate that we got both inputs
        $request->validate([
            'phone' => 'required',
            'email' => 'required|email',
        ]);
    
        // Find the latest order matching BOTH phone and email
        $order = \App\Models\Order::where('phone', $request->phone)
                    ->where('email', $request->email)
                    ->latest() 
                    ->first();
    
        if (!$order) {
            return back()->with('error', 'No order found with this phone number and email combination.');
        }
    
        // Redirect to the result view with the found order
        return view('shop.track-result', compact('order'));
    }
}