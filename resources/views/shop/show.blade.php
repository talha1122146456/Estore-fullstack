<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }} - My Store</title>

    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; margin: 0; }
        
        /* Floating Cart Counter */
        .cart-counter { position: fixed; top: 20px; right: 40px; font-size: 1.5rem; text-decoration: none; z-index: 1000; background: white; padding: 10px; border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .badge { background: red; color: white; border-radius: 50%; padding: 2px 8px; font-size: 0.8rem; position: absolute; top: 0; right: 0; }

        .product-container { max-width: 1000px; margin: auto; background: white; display: flex; gap: 40px; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .image-section { flex: 1; }
        .info-section { flex: 1; }
        .image-section img { width: 100%; border-radius: 8px; object-fit: cover; }
        .price { color: #28a745; font-size: 2rem; font-weight: bold; margin: 20px 0; }
        .description { line-height: 1.6; color: #555; font-size: 1.1rem; }
        .btn-back { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: bold; }

        /* The Box inside the Form */
        .delivery-box { margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px; border: 1px solid #eee; }
        select { width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 1rem; margin-top: 10px; }

        .btn-add { background: #333; color: white; padding: 15px 30px; border: none; border-radius: 6px; cursor: pointer; font-size: 1.2rem; width: 100%; margin-top: 20px; transition: 0.3s; }
        .btn-add:hover { background: #000; }
        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>

<body>

<a href="{{ route('cart.index') }}" class="cart-counter">
    🛒 
    @if(session('cart') && count(session('cart')) > 0)
        <span class="badge">{{ count(session('cart')) }}</span>
    @endif
</a>

<div style="max-width: 1000px; margin: auto;">
    <a href="{{ route('shop.index') }}" class="btn-back">← Back to Shop</a>
    
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
</div>

<div class="product-container">

    <div class="image-section">
        @if($product->image)
            <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}">
        @else
            <div style="background:#ddd;height:400px;display:flex;align-items:center;justify-content:center;border-radius: 8px;">No Image</div>
        @endif
    </div>

    <div class="info-section">
        <small style="text-transform:uppercase;color:#888;letter-spacing: 1px;">
            {{ $product->category->name ?? 'Uncategorized' }}
        </small>

        <h1 style="margin: 10px 0;">{{ $product->name }}</h1>

        <p class="price">${{ number_format($product->price, 2) }}</p>

        <div class="description">
            <strong>Description:</strong>
            <p>{{ $product->description }}</p>
        </div>

        <p>
            <strong>Availability:</strong>
            @if($product->stock > 0)
                <span style="color: green;">{{ $product->stock }} in stock</span>
            @else
                <span style="color: red;">Out of Stock</span>
            @endif
        </p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            
            <div class="delivery-box">
                <label style="font-weight:bold;display:block;">Delivery Option:</label>

                <select name="delivery_price" id="delivery_select">
                    <option value="0" data-name="Standard Delivery">Standard Delivery (Free - 5-7 Days)</option>
                    <option value="15" data-name="Express Delivery">Express Delivery ($15.00 - 1-2 Days)</option>
                    <option value="50" data-name="Next Day Air">Next Day Air ($50.00)</option>
                </select>

                <input type="hidden" name="delivery_name" id="delivery_name" value="Standard Delivery">

                <p style="margin-top:10px;font-size:0.9rem;color:#666;">
                    Estimated Arrival: <span id="delivery_date" style="font-weight: bold;">5-7 business days</span>
                </p>
            </div>

            @if($product->stock > 0)
                <button type="submit" class="btn-add">Add to Cart</button>
            @else
                <button type="button" class="btn-add" style="background: #ccc; cursor: not-allowed;" disabled>Out of Stock</button>
            @endif
        </form>
        </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const select = document.getElementById("delivery_select");
    const dateText = document.getElementById("delivery_date");
    const nameInput = document.getElementById("delivery_name");

    select.addEventListener("change", function(){
        // 1. Update text description
        if(this.value == "0"){
            dateText.innerText = "5-7 business days";
        }
        else if(this.value == "15"){
            dateText.innerText = "1-2 business days";
        }
        else if(this.value == "50"){
            dateText.innerText = "Tomorrow by 5 PM";
        }

        // 2. Update the hidden name field so the cart knows which one was picked
        const selectedOptionName = this.options[this.selectedIndex].getAttribute('data-name');
        nameInput.value = selectedOptionName;
    });
});
</script>

</body>
</html>