<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DSgallery: {{ $artwork->title }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body class="d-flex flex-column" style="min-height:100vh">

@include('header')

<div class="d-flex flex-grow-1">

    <aside>
        <nav>
            <a class="side-link" href="{{ route('home') }}">Home</a>
            <a class="side-link active" href="{{ route('artworks') }}">Artworks</a>
        </nav>
    </aside>

    <main class="p-4 overflow-y-auto flex-grow-1">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible py-2 mb-3" style="font-size:13px">
                {{ session('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h1>{{ $artwork->title }}</h1>

        <div class="row g-4 align-items-start mb-4">

            <!-- Image -->
            <div class="col-12 col-md-8">
                <div class="border rounded-1 overflow-hidden">
                    <div class="img-card" style="height:500px">
                        <img class="art-image" src="{{ asset($artwork->image) }}"
                             alt="{{ $artwork->title }}" style="object-fit:contain"/>
                    </div>
                </div>
            </div>

            <!-- Meta and add-to-cart -->
            <div class="col-12 col-md-4 d-flex flex-column gap-4 pt-2">
                <div>
                    <div class="muted-label">ARTIST</div>
                    <div class="detail-value">{{ $artwork->artist->name }}</div>
                </div>
                <div>
                    <div class="muted-label">DATE</div>
                    <div class="detail-value">{{ $artwork->year }}</div>
                </div>
                <div>
                    <div class="muted-label">GENRE</div>
                    <div class="detail-value">{{ $artwork->genre }}</div>
                </div>
                <div>
                    <div class="muted-label">PRICE</div>
                    <div class="detail-value" style="font-size:22px">
                        {{ number_format($artwork->price, 0) }}€
                    </div>
                </div>

                <div class="border-top pt-3 d-flex flex-column gap-2">

                    <form id="detail-form" method="POST" action="{{ route('cart.add', $artwork) }}">
                        @csrf
                        @php $isSaved = in_array($artwork->artwork_id, session('saved', [])); @endphp
                        <input id="qty" name="quantity" type="hidden" value="1"/>

                        <!-- − 1 + -->
                        <div class="d-flex align-items-center gap-1 mb-2" style="width:100px">
                            <button type="button" class="sm-icon-btn" style="width:100%"
                                    onclick="let i=document.getElementById('qty');let d=document.getElementById('qty-display');i.value=Math.max(1,+i.value-1);d.textContent=i.value">−</button>
                            <span id="qty-display" class="text-center" style="font-size:16px;min-width:20px">1</span>
                            <button type="button" class="sm-icon-btn" style="width:100%"
                                    onclick="let i=document.getElementById('qty');let d=document.getElementById('qty-display');i.value=+i.value+1;d.textContent=i.value">+</button>
                        </div>

                        <!-- Cart + Saved -->
                        <div class="d-flex gap-2" style="width:100px">
                            <button type="submit" class="sm-icon-btn" style="width:100%"
                                    onclick="document.getElementById('detail-form').action='{{ route('cart.add', $artwork) }}'">
                                <img src="{{ asset('icons/cart.svg') }}" alt="Add to cart"/>
                            </button>
                            <button type="submit" class="sm-icon-btn {{ $isSaved ? 'in-saved' : '' }}" style="width:100%"
                                    onclick="document.getElementById('detail-form').action='{{ route('saved.toggle', $artwork) }}'">
                                <img src="{{ asset('icons/bookmark.svg') }}" alt="Save"/>
                            </button>
                        </div>

                    </form>

                    <div class="d-flex">
                        <a class="mid-btn" style="border-width:2px;width:100px;height:28px"
                           href="{{ route('artworks') }}">Go back</a>
                    </div>
                </div>
            </div>
        </div>

        @if ($artwork->description)
            <p style="font-size:18px;color:var(--muted);padding-top:24px">
                {{ $artwork->description }}
            </p>
        @endif

    </main>
</div>

@include('footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
