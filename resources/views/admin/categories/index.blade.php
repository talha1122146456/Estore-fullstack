@extends('layouts.admin')

@section('content')
    <h1>All Categories</h1>

    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; color: #155724; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">
        {{-- Updated the route name to include 'admin.' --}}
        <a href="{{ route('admin.categories.create') }}" style="padding: 10px; background: blue; color: white; text-decoration: none;">
            + Create New Category
        </a>
    </div>

    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <thead style="background: #f4f4f4;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    @foreach($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td>
            <a href="{{ route('admin.categories.edit', $category->id) }}" style="color: #007bff;">Edit</a> | 
            
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Deleting this category may affect products assigned to it. Continue?')" 
                        style="color: red; background: none; border: none; cursor: pointer; text-decoration: underline; padding: 0;">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
    </table>
@endsection