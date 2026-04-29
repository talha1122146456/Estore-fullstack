<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body { font-family: sans-serif; padding: 40px; background: #f4f4f4; }
        .cart-container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .total-section { text-align: right; padding: 20px; font-size: 1.5rem; font-weight: bold; }
        .btn-checkout { background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .qty-input { width: 50px; padding: 5px; border: 1px solid #ddd; border-radius: 4px; text-align: center; }
        .btn-update { background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.8rem; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="cart-container">
    <h1>Shopping Cart</h1>
    <a href="{{ route('shop.index') }}">← Continue Shopping</a>
    <hr>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Delivery</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php 
                        // Subtotal = (Price * Qty) + Delivery Fee
                        $itemTotal = ($details['price'] * $details['quantity']) + $details['delivery_price'];
                        $total += $itemTotal;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $details['name'] }}</strong><br>
                            <small style="color:#666;">{{ $details['delivery_name'] }}</small>
                        </td>
                        <td>${{ number_format($details['price'], 2) }}</td>
                        <td>${{ number_format($details['delivery_price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" style="display: flex; gap: 5px; align-items: center;">
                                @csrf
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="qty-input">
                                <button type="submit" class="btn-update">Update</button>
                            </form>
                        </td>
                        <td>${{ number_format($itemTotal, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" style="color:red; border:none; background:none; cursor:pointer; font-weight:bold;">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <span style="font-size: 1rem; color: #666; font-weight: normal;">Grand Total:</span> 
            ${{ number_format($total, 2) }}
        </div>

        <div style="text-align: right; margin-top: 20px;">
        <a href="{{ route('checkout.index') }}" class="btn-checkout">Proceed to Checkout →</a>
        </div>
    @else
        <div style="text-align: center; padding: 40px;">
            <p style="font-size: 1.2rem; color: #666;">Your cart is empty!</p>
            <a href="{{ route('shop.index') }}" class="btn-update" style="text-decoration:none; padding: 10px 20px;">Go Shopping</a>
        </div>
    @endif
</div>

</body>
</html>