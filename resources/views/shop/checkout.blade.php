<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; margin: 0; }
        .checkout-container { max-width: 1000px; margin: auto; display: flex; gap: 30px; }
        .form-section { flex: 2; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .summary-section { flex: 1; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; height: fit-content; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-order { background: #28a745; color: white; border: none; padding: 15px; width: 100%; border-radius: 6px; font-size: 1.1rem; cursor: pointer; margin-top: 20px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="checkout-container">
    <div class="form-section">
        <h2>Shipping Information</h2>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required placeholder="John Doe">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="john@example.com">
            </div>
            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex:1;">
                    <label>Phone</label>
                    <input type="text" name="phone" required placeholder="0300-1234567">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>City</label>
                    <input type="text" name="city" required placeholder="Rahim Yar Khan">
                </div>
            </div>
            <div class="form-group">
                <label>Complete Address</label>
                <textarea name="address" rows="3" required placeholder="House#, Street#, Area..."></textarea>
            </div>

            <h3>Payment Method</h3>
            <div style="padding: 15px; border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9;">
                <input type="radio" checked style="width: auto;"> <strong>Cash on Delivery (COD)</strong>
            </div>

            <button type="submit" class="btn-order">Place Order Now</button>
        </form>
    </div>

    <div class="summary-section">
        <h3>Order Summary</h3>
        <hr>
        @php $total = 0; @endphp
        @foreach($cart as $id => $details)
            @php 
                $itemTotal = ($details['price'] * $details['quantity']) + $details['delivery_price'];
                $total += $itemTotal;
            @endphp
            <div class="summary-item">
                <span>{{ $details['name'] }} (x{{ $details['quantity'] }})</span>
                <span>${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
            </div>
            <div class="summary-item" style="color: #888; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                <small>+ {{ $details['delivery_name'] }}</small>
                <small>${{ number_format($details['delivery_price'], 2) }}</small>
            </div>
        @endforeach

        <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: bold; margin-top: 20px;">
            <span>Total:</span>
            <span>${{ number_format($total, 2) }}</span>
        </div>
    </div>
</div>

</body>
</html>