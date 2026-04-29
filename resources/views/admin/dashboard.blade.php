@extends('layouts.admin')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome to the admin panel!</p>

    <div style="display: flex; gap: 20px; margin-top: 20px;">
        <div class="card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; min-width: 150px;">
            <h3 style="margin-top: 0;">Total Products</h3>
            <p style="font-size: 24px; font-weight: bold; color: #007bff;">{{ $totalProducts }}</p>
        </div>

        <div class="card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; min-width: 150px;">
            <h3 style="margin-top: 0;">Items in Stock</h3>
            <p style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $totalStock }}</p>
        </div>

        <div class="card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; min-width: 150px;">
            <h3 style="margin-top: 0;">Revenue</h3>
            <p style="font-size: 24px; font-weight: bold; color: #dc3545;">${{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    <hr style="margin: 30px 0;">
    
    <a href="{{ route('admin.products.create') }}" style="display: inline-block; padding: 10px 20px; background: #333; color: white; text-decoration: none; border-radius: 5px;">
        + Add New Product
    </a>
@endsection