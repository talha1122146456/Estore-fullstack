@extends('layouts.shop')

@section('content')
<div class="container">

    <div class="sidebar">
        <h3 style="margin-top:0; color: #2c3e50; font-size: 1.2rem; border-bottom: 2px solid #007bff; display: inline-block; padding-bottom: 5px;">
            Categories
        </h3>
        <ul style="list-style:none; padding:0; margin-top: 20px;">
            <li>
                <a href="{{ route('shop.index') }}"
                style="text-decoration:none; display: block; padding: 8px 0; transition: 0.3s; color:{{ !request('category') ? '#007bff; font-weight:bold;' : '#555' }}">
                All Products
                </a>
            </li>

            @foreach($categories as $category)
            <li style="border-top: 1px solid #f0f0f0;">
                <a href="{{ route('shop.index', ['category'=>$category->id,'search'=>request('search')]) }}"
                    style="text-decoration:none; display: block; padding: 10px 0; transition: 0.3s; color:{{ request('category')==$category->id ? '#007bff; font-weight:bold;' : '#555' }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="main-content">
        
        {{-- Show "Search Results for..." only if a search is active --}}
        @if(request('search'))
            <div style="margin-bottom: 20px; color: #7f8c8d;">
                <p>Showing results for: <strong>"{{ request('search') }}"</strong> 
                <a href="{{ route('shop.index') }}" style="color: #ff4757; margin-left: 10px; text-decoration: none; font-size: 0.8rem;">[Clear Search]</a></p>
            </div>
        @endif

        <div class="product-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="image-wrapper">
                        <a href="{{ route('shop.show',$product->id) }}">
                            @if($product->image)
                                <img src="{{ asset('uploads/products/'.$product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div style="height:180px; background:#f8f9fa; display:flex; align-items:center; justify-content:center; border-radius:8px; color: #ccc;">
                                    No Image
                                </div>
                            @endif
                        </a>

                        <div class="hover-buy">
                            <a href="{{ route('shop.show', $product->id) }}" style="text-decoration:none;">
                                <button type="button" style="font-weight: bold;">VIEW DETAILS</button>
                            </a>
                        </div>
                    </div>

                    <h4 style="margin:15px 0 5px 0; color: #2c3e50; font-weight: 600;">{{ $product->name }}</h4>
                    <p class="price">${{ number_format($product->price, 2) }}</p>
                </div>
            @empty
                <div style="grid-column:1/-1; text-align:center; padding:80px 20px; background:white; border-radius:12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div style="font-size: 3rem; margin-bottom: 10px;">📦</div>
                    <h3 style="color: #2c3e50;">No Products Found</h3>
                    <p style="color: #7f8c8d;">Try adjusting your search or category filters.</p>
                    <a href="{{ route('shop.index') }}" class="btn-search" style="display: inline-block; text-decoration: none; margin-top: 15px; padding: 10px 25px; border-radius: 25px;">Back to Shop</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection