<?php

namespace App\Http\Controllers\Admin;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;  // Import Product Model
use App\Models\Category; // Import Category Model


class ProductController extends Controller
{
    // 1. Show all products in the Admin Panel
    public function index()
    {
        $products = Product::with('category')->get(); // 'with' loads category data efficiently
        return view('admin.products.index', compact('products'));
    }

    // 2. Show the form to create a new product
    public function create()
    {
        $categories = Category::all(); // Get categories for the dropdown
        return view('admin.products.create', compact('categories'));
    }

    // 3. Save the new product (Updated your store method)
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description; // Make sure your migration has this
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
    
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }
    
        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // 4. Admin Dashboard Stats
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalSales = 0; 

        return view('admin.dashboard', compact('totalProducts', 'totalStock', 'totalSales'));
    }

    // 5. Edit a product
    public function edit(Product $product)
{
    $categories = \App\Models\Category::all();
    return view('admin.products.edit', compact('product', 'categories'));
}

public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        // 1. Delete old image from folder
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        // 2. Upload new image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/products'), $imageName);
        $data['image'] = $imageName;
    }

    $product->update($data);

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}

public function destroy(Product $product)
{
    // Delete the image file if it exists
    if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
        unlink(public_path('uploads/products/' . $product->image));
    }

    $product->delete();

    return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
}


// List all orders
public function orders() {
    $orders = Order::latest()->get();
    return view('admin.orders.index', compact('orders'));
}

// Show specific order details
public function orderShow(Order $order) {
    $order->load('items');
    return view('admin.orders.show', compact('order'));
}

// NEW: Update Order Status
public function orderUpdateStatus(Request $request, Order $order) {
    $request->validate([
        'status' => 'required|in:pending,shipped,completed,cancelled'
    ]);

    $order->update(['status' => $request->status]);

    return back()->with('success', 'Order status updated to ' . $request->status);
}

public function orderInvoice(Order $order) {
    $order->load('items');
    return view('admin.orders.invoice', compact('order'));
}





}




