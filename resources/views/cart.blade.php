<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DSgallery: cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body class="d-flex flex-column" style="min-height:100vh">

<!-- Header -->
<nav class="navbar px-4 py-2 border-bottom sticky-top bg-white d-flex justify-content-between">
    <a href="{{ route('home') }}"><img src="{{ asset('images/home/logo.png') }}" alt="DSgallery" style="max-height:40px"/></a>
    <div class="d-flex align-items-center gap-2">
        <div class="search-wrap">
            <input type="text" placeholder="Search"/>
            <img class="icon-search" src="{{ asset('icons/search.svg') }}" alt=""/>
        </div>
        <a class="mid-icon-btn active" href="{{ route('cart') }}"><img src="{{ asset('icons/cart.svg') }}" alt="Cart"/></a>
        <a class="mid-icon-btn" href="{{ route('saved') }}"><img src="{{ asset('icons/bookmark.svg') }}" alt="Saved"/></a>
        @auth
            <span class="mid-btn" style="pointer-events:none">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mid-btn">Log out</button>
            </form>
        @else
            <a class="mid-btn" href="{{ route('login') }}">Log in</a>
            <a class="mid-btn" href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>

<!-- Body -->
<div class="d-flex flex-grow-1">

    <!-- Sidebar -->
    <aside>
        <nav>
            <a class="side-link" href="{{ route('home') }}">Home</a>
            <a class="side-link" href="{{ route('artworks') }}">Artworks</a>
        </nav>
    </aside>

    <!-- Cart -->
    <main class="p-4 flex-grow-1" style="min-width:0;overflow-y:auto">
        <h1>Cart</h1>

        <div class="row gx-3 align-items-center py-3 border-bottom border-top">
            <div class="col-auto col-md-1">
                <img class="cart-img" src="{{ asset('images/art/van_gogh/Bridges_across_the_Seine_at_Asnieres.jpg') }}" alt=""/>
            </div>
            <div class="col col-md-5">
                <h2>Bridges Across the Seine at Asnières</h2>
            </div>
            <div class="col-auto col-md-3">
                <div class="qty-control">
                    <button class="qty-btn">−</button>
                    <input class="qty-num" type="number" min="1" value="1"/>
                    <button class="qty-btn">+</button>
                </div>
            </div>
            <div class="col-auto col-md-2">
                <h2>879€</h2>
            </div>
            <div class="row col-md-1 gap-1">
                <button class="sm-icon-btn in-cart"><img src="{{ asset('icons/cart.svg') }}" alt=""/></button>
                <button class="sm-icon-btn"><img src="{{ asset('icons/bookmark.svg') }}" alt=""/></button>
            </div>
        </div>

        <div class="row gx-3 align-items-center py-3 border-bottom">
            <div class="col-auto col-md-1">
                <img class="cart-img" src="{{ asset('images/art/van_gogh/Cafe_Terrace_at_Night.jpg') }}" alt=""/>
            </div>
            <div class="col col-md-5">
                <h2>Café Terrace at Night</h2>
            </div>
            <div class="col-auto col-md-3">
                <div class="qty-control">
                    <button class="qty-btn">−</button>
                    <input class="qty-num" type="number" min="1" value="1"/>
                    <button class="qty-btn">+</button>
                </div>
            </div>
            <div class="col-auto col-md-2">
                <h2>950€</h2>
            </div>
            <div class="row col-md-1 gap-1">
                <button class="sm-icon-btn in-cart"><img src="{{ asset('icons/cart.svg') }}" alt=""/></button>
                <button class="sm-icon-btn"><img src="{{ asset('icons/bookmark.svg') }}" alt=""/></button>
            </div>
        </div>

        <div class="mt-4 border-top pt-3">
            <div class="d-flex justify-content-end mb-4 mt-1">
                <span style="font-size:22px;font-weight:500;font-family:var(--font-body)">1 829€</span>
            </div>
            <div class="d-flex justify-content-end">
                <a class="order-btn" href="{{ route('cart.shipping') }}">Continue to shipping</a>
            </div>
            @guest
                <p class="text-end text-muted small mt-3">Already have an account?
                    <a href="{{ route('login') }}" class="text-dark fw-semibold text-decoration-none">Log in</a>
                </p>
            @endguest
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="d-flex align-items-center gap-3 py-3 border-top" style="background:var(--card-bg); padding-left:1.5rem; padding-right:1.5rem">
    <div class="d-flex gap-3">
        <a href="#" class="opacity-50"><img src="{{ asset('icons/twitter.svg') }}" alt="Twitter" style="width:15px; height:15px"/></a>
        <a href="#" class="opacity-50"><img src="{{ asset('icons/instagram.svg') }}" alt="Instagram" style="width:15px; height:15px"/></a>
        <a href="#" class="opacity-50"><img src="{{ asset('icons/youtube.svg') }}" alt="YouTube" style="width:15px; height:15px"/></a>
        <a href="#" class="opacity-50"><img src="{{ asset('icons/linkedin.svg') }}" alt="LinkedIn" style="width:15px; height:15px"/></a>
    </div>
    <p class="mb-0 text-muted small">© 2026 DSgallery. All rights reserved.</p>
</footer>

</body>
</html>
