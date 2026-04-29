@extends('layouts.admin')

@section('content')
    <h1>Add New Category</h1>

    {{-- The route name must be admin.categories.store --}}
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div style="margin-bottom: 15px;">
            <label>Category Name:</label><br>
            <input type="text" name="name" required placeholder="e.g. Electronics" style="padding: 8px; width: 300px;">
        </div>

        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px;">
            Save Category
        </button>
    </form>

    <br>
    <a href="{{ route('admin.categories.index') }}">← Back to List</a>
@endsection