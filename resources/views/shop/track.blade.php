@extends('layouts.shop')

@section('content')
<div style="max-width: 500px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #2c3e50;">Track Your Order</h2>
    <p style="text-align: center; color: #7f8c8d; margin-bottom: 30px;">Enter your details to check your latest order progress.</p>

    <form action="{{ route('shop.track.search') }}" method="GET">
        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold;">Phone Number</label>
            <input type="text" name="phone" required placeholder="e.g. 03001234567" 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="font-weight: bold;">Email Address</label>
            <input type="email" name="email" required placeholder="Enter your email" 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px; box-sizing: border-box;">
        </div>

        <button type="submit" style="width: 100%; background: #3498db; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s;">
            Find My Order
        </button>
    </form>

    @if(session('error'))
        <div style="background: #fdf2f2; border: 1px solid #facccc; padding: 10px; border-radius: 5px; margin-top: 20px;">
            <p style="color: #e74c3c; text-align: center; margin: 0; font-size: 0.9rem;">{{ session('error') }}</p>
        </div>
    @endif
</div>
@endsection