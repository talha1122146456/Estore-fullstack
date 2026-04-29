@extends('layouts.admin')

@section('content')
    <h1>Edit Category: {{ $category->name }}</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 15px;">
            <label>Category Name:</label><br>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="padding: 8px; width: 300px;">
        </div>

        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px;">
            Update Category
        </button>
        <a href="{{ route('admin.categories.index') }}" style="margin-left: 10px;">Cancel</a>
    </form>
@endsection