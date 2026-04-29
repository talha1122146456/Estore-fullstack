<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - My Store</title>
    <style>
        body { display: flex; font-family: sans-serif; margin: 0; background: #f8f9fa; }
        
        /* Sidebar Styles */
        .sidebar { width: 240px; background: #2c3e50; color: white; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar h3 { margin-bottom: 30px; color: #ecf0f1; border-bottom: 1px solid #3e4f5f; padding-bottom: 10px; }
        .sidebar a { color: #bdc3c7; display: block; padding: 12px 15px; text-decoration: none; border-radius: 5px; transition: 0.3s; }
        .sidebar a:hover { background: #34495e; color: white; }
        .sidebar a.active { background: #3498db; color: white; }
        
        /* Logout Button Style */
        .logout-btn { background: none; border: none; color: #e74c3c; padding: 12px 15px; cursor: pointer; font-size: 1rem; width: 100%; text-align: left; font-family: sans-serif; transition: 0.3s; }
        .logout-btn:hover { background: #c0392b; color: white; border-radius: 5px; }

        /* Content Area */
        .content { flex: 1; padding: 40px; }
        hr { border: 0; border-top: 1px solid #3e4f5f; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Store Admin</h3>
        
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">📁 Categories</a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">📦 Products</a>
        
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">🛒 Orders</a>
        
        <hr>
        
        <a href="{{ route('shop.index') }}" target="_blank">🌐 View Storefront</a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>

    <div class="content">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>