@extends('layouts.shop')

@section('content')
<div style="max-width: 600px; margin: 50px auto; text-align: center; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.08); animation: slideUp 0.6s ease-out;">
    
    <div style="width: 80px; height: 80px; background: #28a745; color: white; border-radius: 50%; line-height: 80px; font-size: 40px; margin: 0 auto 20px; box-shadow: 0 10px 20px rgba(40, 167, 69, 0.2); animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        ✓
    </div>

    <h1 style="color: #2c3e50; margin-bottom: 10px; font-weight: 800;">Order Placed!</h1>
    <p style="color: #7f8c8d; font-size: 16px;">Thank you for shopping with us, <strong>{{ $order->full_name }}</strong>. Your order is being processed.</p>

    <div style="background: #f8f9fa; border: 1px dashed #cbd5e0; padding: 20px; border-radius: 12px; margin: 30px 0; text-align: left;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="color: #64748b;">Order ID:</span>
            <span style="font-weight: bold; color: #007bff;">#{{ $order->id }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="color: #64748b;">Total Amount:</span>
            <span style="font-weight: bold; color: #28a745;">${{ number_format($order->total_amount, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Estimated Delivery:</span>
            <span style="font-weight: bold; color: #2c3e50;">3-5 Business Days</span>
        </div>
    </div>

    <p style="color: #94a3b8; font-size: 14px; margin-bottom: 30px;">
        A confirmation email has been sent to {{ $order->email }}.
    </p>

    <div style="display: flex; gap: 15px; justify-content: center;">
        <a href="{{ route('shop.track') }}" style="flex: 1; padding: 12px; background: #007bff; color: white; text-decoration: none; border-radius: 30px; font-weight: bold; transition: 0.3s; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);"
           onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            Track Order
        </a>
        <a href="{{ route('shop.index') }}" style="flex: 1; padding: 12px; background: white; color: #007bff; border: 2px solid #007bff; text-decoration: none; border-radius: 30px; font-weight: bold; transition: 0.3s;"
           onmouseover="this.style.background='#f0f7ff'" onmouseout="this.style.background='white'">
            Continue Shopping
        </a>
    </div>
</div>

<style>
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }
</style>
@endsection