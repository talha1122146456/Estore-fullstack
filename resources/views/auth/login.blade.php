@extends('layouts.auth_layout')

@section('title', 'Login')

@section('content')
    <h2 style="text-align: center; color: #333; margin-bottom: 10px;">Welcome Back</h2>
    <p style="text-align: center; color: #777; font-size: 0.9rem; margin-bottom: 30px;">Login to manage your account</p>

    @if($errors->any())
        <div class="alert" style="background: #fee2e2; color: #dc2626; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="example@gmail.com">

        <label class="form-label">Password</label>
        <div style="position: relative; display: flex; align-items: center; margin-bottom: 20px;">
            <input type="password" name="password" id="password" class="form-input" required placeholder="Enter your password" style="flex-grow: 1; padding-right: 60px; margin-bottom: 0;">
            
            <button type="button" id="togglePassword" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: #007bff; font-size: 0.75rem; font-weight: bold; outline: none;">
                SHOW
            </button>
        </div>

        <button type="submit" class="btn-submit" style="background: #007bff;">Login</button>
    </form>

    <div style="margin-top: 30px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
        <p style="color: #666; font-size: 0.9rem;">
            Don't have an account? <a href="{{ route('register') }}" style="color: #007bff; text-decoration: none; font-weight: bold;">Register here</a>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function () {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle the button text
                this.textContent = type === 'password' ? 'SHOW' : 'HIDE';
            });
        });
    </script>
@endsection