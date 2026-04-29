@extends('layouts.auth_layout')

@section('title', 'Create Account')

@section('content')
    <div class="auth-header">
        <h2 style="text-align: center; color: #333; margin-bottom: 10px;">Create Account</h2>
    </div>

    @if($errors->any())
        <div class="alert" style="background: #fee2e2; color: #dc2626; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="John Doe" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="john@example.com" required>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div style="position: relative; width: 100%;">
                <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required style="width: 100%; padding-right: 45px; margin-bottom: 0;">
                <button type="button" class="toggle-password" data-target="password" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #777; display: flex; align-items: center; padding: 0; outline: none;">
                    <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <div class="form-group" style="margin-top: 15px;">
            <label class="form-label">Confirm Password</label>
            <div style="position: relative; width: 100%;">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="••••••••" required style="width: 100%; padding-right: 45px; margin-bottom: 0;">
                <button type="button" class="toggle-password" data-target="password_confirmation" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #777; display: flex; align-items: center; padding: 0; outline: none;">
                    <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <div style="margin: 25px 0; display: flex; align-items: flex-start; gap: 10px;">
            <input type="checkbox" name="terms" id="terms" required 
                   style="width: 18px; height: 18px; cursor: pointer; margin-top: 2px;">
            <label for="terms" style="color: #666; font-size: 0.85rem; line-height: 1.4; cursor: pointer;">
                I agree to the <a href="#" style="color: #007bff; text-decoration: none; font-weight: 600;">Terms</a> and <a href="#" style="color: #007bff; text-decoration: none; font-weight: 600;">Privacy</a>.
            </label>
        </div>

        <button type="submit" class="btn-submit" style="background: #007bff; width: 100%;">
            Create Account
        </button>
    </form>

    <div style="text-align: center; border-top: 1px solid #eee; padding-top: 15px; margin-top: 20px;">
        <p style="color: #666; font-size: 0.9rem;">
            Already have an account? <a href="{{ route('login') }}" style="color: #007bff; text-decoration: none; font-weight: bold;">Login here</a>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-password');
            const eyeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            const eyeOffIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    this.innerHTML = isPassword ? eyeOffIcon : eyeIcon;
                });
            });
        });
    </script>
@endsection