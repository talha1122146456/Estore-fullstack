@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <a href="{{ route('admin.orders.index') }}" style="text-decoration: none; color: #3498db; font-weight: bold;">← Back to Orders</a>
        <h2 style="margin-top: 10px; color: #2c3e50;">Order Details: #{{ $order->id }}</h2>
    </div>
    <div style="text-align: right;">
        <span style="color: #7f8c8d;">Order Placed:</span><br>
        <strong>{{ $order->created_at->format('M d, Y - h:i A') }}</strong>
    </div>
</div>

<div style="display: flex; gap: 20px; align-items: flex-start;">
    
    <div style="flex: 1;">
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0; color: #2c3e50;">Customer Info</h3>
            <p style="margin: 10px 0;"><strong>Name:</strong> {{ $order->full_name }}</p>
            <p style="margin: 10px 0;"><strong>Email:</strong> {{ $order->email }}</p>
            <p style="margin: 10px 0;"><strong>Phone:</strong> {{ $order->phone }}</p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; color: #2c3e50;">Shipping Address</h3>
            <p style="margin: 10px 0;"><strong>City:</strong> {{ $order->city }}</p>
            <p style="margin: 10px 0; line-height: 1.5;"><strong>Address:</strong> {{ $order->address }}</p>
        </div>

        <div style="background: #fdfdfd; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0;">
            <h3 style="margin-top: 0; font-size: 1.1rem; color: #2c3e50;">Manage Order Status</h3>
            <p>Current Status: 
                <span style="padding: 3px 8px; border-radius: 4px; background: #fff3cd; color: #856404; font-weight: bold; font-size: 0.85rem;">
                    {{ strtoupper($order->status) }}
                </span>
            </p>
            
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                <select name="status" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-bottom: 15px; font-size: 1rem;">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" style="width: 100%; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    <div style="flex: 2; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0; color: #2c3e50;">Ordered Items</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="text-align: left; background: #f8f9fa;">
                    <th style="padding: 12px; border-bottom: 2px solid #eee;">Product</th>
                    <th style="padding: 12px; border-bottom: 2px solid #eee;">Price</th>
                    <th style="padding: 12px; border-bottom: 2px solid #eee; text-align: center;">Qty</th>
                    <th style="padding: 12px; border-bottom: 2px solid #eee;">Delivery</th>
                    <th style="padding: 12px; border-bottom: 2px solid #eee; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="padding: 15px 12px; border-bottom: 1px solid #eee;">
                        <strong>{{ $item->product_name }}</strong>
                    </td>
                    <td style="padding: 15px 12px; border-bottom: 1px solid #eee;">${{ number_format($item->price, 2) }}</td>
                    <td style="padding: 15px 12px; border-bottom: 1px solid #eee; text-align: center;">{{ $item->quantity }}</td>
                    <td style="padding: 15px 12px; border-bottom: 1px solid #eee; font-size: 0.9rem; color: #555;">
                        {{ $item->delivery_method }}<br>
                        <strong>${{ number_format($item->delivery_price, 2) }}</strong>
                    </td>
                    <td style="padding: 15px 12px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold;">
                        ${{ number_format(($item->price * $item->quantity) + $item->delivery_price, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; padding: 20px; font-weight: bold; font-size: 1.2rem; color: #7f8c8d;">Grand Total:</td>
                    <td style="padding: 20px; text-align: right; font-weight: bold; font-size: 1.4rem; color: #27ae60;">
                        ${{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" 
                  style="background: #e67e22; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                  📄 Generate Invoice
                </a>
            </tfoot>
        </table>
    </div>
</div>
@endsection