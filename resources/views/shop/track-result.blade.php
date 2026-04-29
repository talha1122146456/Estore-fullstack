@extends('layouts.shop')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #eee;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f8f9fa; padding-bottom: 25px; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; color: #2c3e50; font-size: 24px;">Order #{{ $order->id }}</h2>
            <p style="margin: 5px 0 0; color: #7f8c8d; font-size: 14px;">Placed on {{ $order->created_at->format('M d, Y') }}</p>
        </div>
        <div style="text-align: right;">
            <span style="display: inline-block; padding: 8px 20px; background: #007bff15; color: #007bff; border-radius: 30px; font-weight: 800; font-size: 13px; letter-spacing: 1px;">
                ● {{ strtoupper($order->status) }}
            </span>
        </div>
    </div>

    <div style="padding: 20px 0 50px 0;">
        <div style="display: flex; justify-content: space-between; position: relative; max-width: 600px; margin: 0 auto;">
            <div style="position: absolute; top: 20px; left: 0; width: 100%; height: 4px; background: #f0f0f0; z-index: 1; border-radius: 10px;"></div>
            
            @php
                $statuses = ['pending', 'shipped', 'completed'];
                $currentIdx = array_search(strtolower($order->status), $statuses);
            @endphp

            @foreach($statuses as $index => $s)
                <div style="z-index: 2; text-align: center; width: 100px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; margin: 0 auto; 
                                background: {{ $index <= $currentIdx ? '#28a745' : 'white' }}; 
                                border: 4px solid {{ $index <= $currentIdx ? '#28a745' : '#f0f0f0' }};
                                color: {{ $index <= $currentIdx ? 'white' : '#bdc3c7' }}; 
                                line-height: 38px; font-weight: bold; font-size: 18px;
                                transition: all 0.4s ease;
                                box-shadow: {{ $index <= $currentIdx ? '0 0 15px rgba(40, 167, 69, 0.3)' : 'none' }};">
                        {{ $index < $currentIdx ? '✓' : $index + 1 }}
                    </div>
                    <p style="font-size: 13px; margin-top: 15px; color: {{ $index <= $currentIdx ? '#2c3e50' : '#bdc3c7' }}; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $s }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
        <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; border: 1px solid #f0f0f0;">
            <h4 style="margin-top: 0; color: #007bff; font-size: 14px; text-transform: uppercase;">Delivery Details</h4>
            <p style="margin: 10px 0; color: #2c3e50;"><strong>{{ $order->full_name }}</strong></p>
            <p style="margin: 5px 0; color: #7f8c8d; font-size: 14px; line-height: 1.6;">
                {{ $order->address }}<br>
                {{ $order->city }}, Pakistan<br>
                {{ $order->phone }}
            </p>
        </div>

        <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; border: 1px solid #f0f0f0;">
            <h4 style="margin-top: 0; color: #007bff; font-size: 14px; text-transform: uppercase;">Payment Summary</h4>
            <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                <span style="color: #7f8c8d;">Status</span>
                <span style="font-weight: bold; color: #2c3e50;">Cash on Delivery</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #ddd;">
                <span style="color: #2c3e50; font-weight: bold;">Total Amount</span>
                <span style="color: #28a745; font-weight: 800; font-size: 18px;">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('shop.track') }}" style="display: inline-block; padding: 12px 30px; color: #007bff; text-decoration: none; font-weight: bold; border: 2px solid #007bff; border-radius: 30px; transition: 0.3s;" 
           onmouseover="this.style.background='#007bff'; this.style.color='white';" 
           onmouseout="this.style.background='transparent'; this.style.color='#007bff';">
            ← Track Another Order
        </a>
    </div>
</div>
@endsection