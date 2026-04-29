@extends('layouts.admin')

@section('content')
<div style="max-width: 600px;">
    <h1>Add New Product</h1>
    <a href="{{ route('admin.products.index') }}">← Back to List</a>
    <hr>

    {{-- Error Handling: Shows validation errors from ProductController --}}
    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Product Name:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Wireless Mouse" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Category:</label><br>
            <select name="category_id" style="width: 100%; padding: 8px;">
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
    <label>Description:</label><br>
    <textarea name="description" required style="width: 100%; padding: 8px;" rows="4">{{ old('description') }}</textarea>
</div>

        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label>Price ($):</label><br>
                <input type="number" name="price" step="0.01" value="{{ old('price') }}" style="width: 100%; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label>Stock Quantity:</label><br>
                <input type="number" name="stock" value="{{ old('stock') }}" style="width: 100%; padding: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label>Product Image:</label><br>
            <input type="file" name="image" style="padding: 10px 0;">
        </div>

        <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold;">
            Save Product
        </button>
    </form>
</div>
@endsection