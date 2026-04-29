<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Show the Cart page
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('shop.cart', compact('cart'));
    }

    // Add item to Cart with Stock Check
    public function add(Request $request, Product $product)
    {
        // 1. Check if product is even in stock
        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, ' . $product->name . ' is currently out of stock.');
        }

        $cart = session()->get('cart', []);
        $delivery_price = $request->delivery_price ?? 0;
        $delivery_name = $request->delivery_name ?? 'Standard';

        // Unique ID for cart item
        $cartId = $product->id . '_' . $delivery_name;

        if(isset($cart[$cartId])) {
            // 2. Check if adding another exceeds stock
            if ($cart[$cartId]['quantity'] + 1 > $product->stock) {
                return back()->with('error', 'Only ' . $product->stock . ' units available.');
            }
            $cart[$cartId]['quantity']++;
        } else {
            $cart[$cartId] = [
                "product_id" => $product->id, // Store ID to find it later during checkout
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
                "delivery_name" => $delivery_name,
                "delivery_price" => $delivery_price
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $product = Product::find($cart[$id]['product_id']);
            $quantity = max(1, intval($request->quantity));

            // Check stock before updating quantity
            if ($product && $quantity > $product->stock) {
                return back()->with('error', 'Only ' . $product->stock . ' items available in stock.');
            }

            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cart updated successfully!');
        }

        return back()->with('error', 'Item not found.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Item removed.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }
        return view('shop.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        // 1. Validate User Input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string|min:10',
            'city'      => 'required|string',
            'address'   => 'required|string',
        ]);

        $cart = session()->get('cart');
        if (!$cart) return redirect()->route('shop.index');

        try {
            DB::beginTransaction();

            // 2. Calculate Total & Verify Stock one last time
            $total = 0;
            foreach($cart as $id => $item) {
                $product = Product::lockForUpdate()->find($item['product_id']); // Lock row for safety
                
                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception("Product {$item['name']} ran out of stock while you were checking out!");
                }

                $total += ($item['price'] * $item['quantity']) + $item['delivery_price'];
                
                // 3. Deduct Stock
                $product->decrement('stock', $item['quantity']);
            }

            // 4. Create Order
            $order = Order::create([
                'user_id'      => auth()->id(), // Optional: link to logged in user
                'full_name'    => $request->full_name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'city'         => $request->city,
                'address'      => $request->address,
                'total_amount' => $total,
                'status'       => 'pending'
            ]);

            // 5. Create Order Items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item['product_id'],
                    'product_name'    => $item['name'],
                    'price'           => $item['price'],
                    'quantity'        => $item['quantity'],
                    'delivery_method' => $item['delivery_name'],
                    'delivery_price'  => $item['delivery_price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');
            
            return view('shop.success', compact('order'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }
}