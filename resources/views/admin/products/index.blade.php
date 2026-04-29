@extends('layouts.admin')

@section('content')
    <h1>Admin - Product Management</h1>

    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; color: #155724; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.products.create') }}" style="padding: 10px; background: blue; color: white; text-decoration: none; border-radius: 4px;">
            + Add New Product
        </a>
        <a href="{{ route('admin.dashboard') }}" style="margin-left: 10px;">Back to Dashboard</a>
    </div>

    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; background: white;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td align="center">
                        @if($product->image)
                            <img src="{{ asset('uploads/products/' . $product->image) }}" width="60" height="60" style="object-fit: cover; border-radius: 4px;">
                        @else
                            <span style="color: #999; font-size: 0.8rem;">No Image</span>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" style="color: #007bff;">Edit</a> | 
                        
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this?')" style="color: red; border: none; background: none; cursor: pointer; text-decoration: underline;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">No products found. Start by adding one!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection