<!DOCTYPE html>
<html>
<head>
    <title>My Laravel Store</title>
    <style>
        /* KEEPING YOUR CORE STYLING */
        body{ font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; margin:0; padding:0; background:#f4f4f4; padding-top: 160px; }
        .container{ display:flex; gap:20px; max-width:1200px; margin:auto; padding-bottom: 50px; }
        .sidebar{ width:250px; background:white; padding:15px; border-radius:12px; height:fit-content; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .main-content{ flex:1; }
        .product-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; }
        .product-card{ background:white; padding:15px; border-radius:12px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.06); position:relative; overflow:hidden; transition:all 0.3s ease; border: 1px solid #eee; }
        .product-card:hover{ transform:translateY(-8px); box-shadow:0 12px 24px rgba(0,0,0,0.12); border-color: #007bff; }
        .product-card img{ width:100%; height:180px; object-fit:cover; border-radius:8px; }
        .price{ color:#28a745; font-weight:bold; font-size:1.2rem; margin-top: 8px; }

        /* --- STYLISH NAVBAR --- */
        .main-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            z-index: 1000;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .logo-text {
            font-size: 26px;
            font-weight: 800;
            color: #007bff;
            text-decoration: none;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-item {
            text-decoration: none;
            color: #007bff; /* Consistent Blue Color */
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-item:hover {
            opacity: 0.7;
            transform: translateY(-1px);
        }

        /* --- ANIMATED SEARCH BAR --- */
        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input-animated {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            border: 2px solid #007bff;
            padding: 0 15px;
            outline: none;
            transition: width 0.4s cubic-bezier(0.000, 0.795, 0.000, 0.995);
            cursor: pointer;
            background: transparent;
        }

        .search-input-animated:focus {
            width: 250px;
            cursor: text;
            background: white;
        }

        .search-icon-btn {
            position: absolute;
            right: 12px;
            pointer-events: none;
            color: #007bff;
            font-weight: bold;
        }

        /* --- CENTERED HERO TEXT --- */
        .hero-section {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease-out;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 900;
            color: #2c3e50;
            margin: 0;
            background: linear-gradient(to right, #2c3e50, #007bff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            color: #7f8c8d;
            font-size: 18px;
            margin-top: 10px;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cart-badge {
            background: #ff4757;
            color: white;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 10px;
            margin-left: 4px;
        }

        .logout-link {
            color: #ff4757;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="header-content">
        <a href="{{ route('shop.index') }}" class="logo-text">MY STORE</a>

        <div class="nav-links">
            <form action="{{ route('shop.index') }}" method="GET" class="search-box">
                <input type="text" name="search" class="search-input-animated" placeholder="Search..." value="{{ request('search') }}">
                <span class="search-icon-btn">🔍</span>
            </form>

            <a href="{{ route('shop.track') }}" class="nav-item">TRACKING</a>
            
            <a href="{{ route('cart.index') }}" class="nav-item">
                CART <span class="cart-badge">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="nav-item">ADMIN</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-link">LOGOUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-item">LOGIN</a>
            @endauth
        </div>
    </div>
</header>

<div class="hero-section">
    <h1 class="hero-title">Discover Our Collection</h1>
    <p class="hero-subtitle">Premium quality products, delivered to your doorstep in Rahim Yar Khan.</p>
</div>

@yield('content')

</body>
</html>