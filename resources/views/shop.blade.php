<form action="{{ route('shop.index') }}" method="GET">
    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>

<hr>

<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    @forelse($products as $product)
        <div class="product-card">
            <img src="{{ asset('uploads/products/' . $product->image) }}" width="150">
            <h3>{{ $product->name }}</h3>
            <p>${{ $product->price }}</p>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
</div>