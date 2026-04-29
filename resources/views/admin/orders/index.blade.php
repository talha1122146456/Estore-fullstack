@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Customer Orders</h2>
    <span style="background: #3498db; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;">
        Total Orders: {{ $orders->count() }}
    </span>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th { background: #f8f9fa; padding: 15px; text-align: left; border-bottom: 2px solid #eee; color: #333; }
        .admin-table td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .admin-table tr:hover { background: #fcfcfc; }
        
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-completed { background: #d4edda; color: #155724; }
        .badge-shipped { background: #cce5ff; color: #004085; }
        
        .btn-view { text-decoration: none; background: #2c3e50; color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; }
        .btn-view:hover { background: #34495e; }
    </style>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-weight: bold; color: #3498db;">#{{ $order->id }}</td>
                <td>
                    <div style="font-weight: bold;">{{ $order->full_name }}</div>
                    <div style="font-size: 0.8rem; color: #777;">{{ $order->city }}</div>
                </td>
                <td style="font-weight: bold;">${{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->created_at->format('d M, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $order->status }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-view">🔍 View Details</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #888;">
                    No orders found yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection