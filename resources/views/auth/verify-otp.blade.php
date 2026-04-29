@extends('layouts.auth_layout')

@section('title', 'Verify OTP')

@section('content')
    <div class="auth-header">
        <h2 style="text-align: center; color: #333; margin-bottom: 10px;">Enter OTP</h2>
        <p style="text-align: center; color: #666; font-size: 0.9rem; margin-bottom: 30px;">We sent a 6-digit code to your email.</p>
    </div>

    @if(session('success'))
        <div class="success-alert">{{ session('success') }}</div>
    @endif

    @if($errors->has('otp'))
        <div class="alert" id="error-alert">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('otp.verify.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="otp" placeholder="123456" required autofocus
                   class="form-input"
                   style="text-align: center; font-size: 1.5rem; letter-spacing: 5px; font-weight: bold;">
        </div>
        
        <button type="submit" class="btn-submit" style="background-color: #007bff;">
            VERIFY & LOGIN
        </button>
    </form>

    <div style="margin-top: 25px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
        <div id="resend-container">
            <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Didn't receive the code?</p>
            
            <a href="{{ route('otp.resend') }}" id="resend-link"
               onclick="this.style.display='none'; document.getElementById('resend-spinner').style.display='inline-block';" 
               style="color: #007bff; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                Resend New Code
            </a>

            <span id="resend-spinner" style="display:none; color: #666; font-size: 0.9rem;">Sending...</span>

            <p id="timer-text" style="display:none; color: #e53e3e; font-size: 0.85rem; font-weight: 600;">
                You can resend in <span id="seconds">60</span>s
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorText = document.getElementById('error-alert')?.innerText || '';
            const resendLink = document.getElementById('resend-link');
            const timerText = document.getElementById('timer-text');
            const secondsSpan = document.getElementById('seconds');

            // Check if the error message contains a number (seconds from RateLimiter)
            const match = errorText.match(/(\d+)/);
            
            if (match) {
                let timeLeft = parseInt(match[1]);
                
                // Hide link, show timer
                resendLink.style.display = 'none';
                timerText.style.display = 'block';

                const countdown = setInterval(() => {
                    timeLeft--;
                    secondsSpan.innerText = timeLeft;

                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        resendLink.style.display = 'inline-block';
                        timerText.style.display = 'none';
                    }
                }, 1000);
            }
        });
    </script>
@endsection