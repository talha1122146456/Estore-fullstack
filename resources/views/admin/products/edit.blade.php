@extends('layouts.admin')

@section('content')
<div style="max-width: 700px; background: white; padding: 20px; border-radius: 8px;">
    <h1>Edit Product: {{ $product->name }}</h1>
    <hr>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Product Name:</label><br>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Category:</label><br>
            <select name="category_id" required style="width: 100%; padding: 8px;">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Description:</label><br>
            <textarea name="description" style="width: 100%; padding: 8px;" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label>Price ($):</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required style="width: 100%; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label>Stock:</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required style="width: 100%; padding: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Current Image:</label><br>
            @if($product->image)
                <img src="{{ asset('uploads/products/' . $product->image) }}" width="100" style="border-radius: 4px; margin-bottom: 10px;">
            @endif
            <br>
            <label>Change Image (Optional):</label>
            <input type="file" name="image">
        </div>

        <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px;">
            Update Product
        </button>
        <a href="{{ route('admin.products.index') }}" style="margin-left: 10px;">Cancel</a>
    </form>
</div>
@endsection