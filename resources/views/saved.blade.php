<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DSgallery: Saved</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body class="d-flex flex-column" style="min-height:100vh">

@include('header')
<div class="d-flex flex-grow-1">
    <aside>
        <nav>
            <a class="side-link" href="{{ route('home') }}">Home</a>
            <a class="side-link" href="{{ route('artworks') }}">Artworks</a>
        </nav>
    </aside>

    <main class="p-4 overflow-y-auto flex-grow-1">
        <h1>Saved</h1>

        @if (session('success'))
            <div class="alert alert-success py-2 mb-3" style="font-size:13px">{{ session('success') }}</div>
        @endif

        @if ($saved->isEmpty())
            <div class="text-center py-5 text-muted">
                <p style="font-size:18px">No saved artworks yet.</p>
                <a href="{{ route('artworks') }}" class="btn btn-dark mt-2">Browse artworks</a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                @foreach ($saved as $artwork)
                    <div class="col">
                        <figure class="card p-0 h-100">
                            <a class="img-card tile-img" href="{{ route('detail', $artwork) }}">
                                <img class="art-image" src="{{ asset($artwork->image) }}" alt="{{ $artwork->title }}"/>
                                <div class="tile-btns">
                                    {{-- Add to cart --}}
                                    <form method="POST" action="{{ route('cart.add', $artwork) }}">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1"/>
                                        <button type="submit" class="sm-icon-btn" title="Add to cart">
                                            <img src="{{ asset('icons/cart.svg') }}" alt=""/>
                                        </button>
                                    </form>
                                    {{-- Remove from saved --}}
                                    <form method="POST" action="{{ route('saved.toggle', $artwork) }}">
                                        @csrf
                                        <button type="submit" class="sm-icon-btn in-saved" title="Remove from saved">
                                            <img src="{{ asset('icons/bookmark.svg') }}" alt=""/>
                                        </button>
                                    </form>
                                </div>
                            </a>
                            <div class="tile-info">
                                <figcaption class="name">{{ $artwork->title }}</figcaption>
                                <div class="price">{{ number_format($artwork->price, 0) }}€</div>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>

@include('footer')
</body>
</html>
