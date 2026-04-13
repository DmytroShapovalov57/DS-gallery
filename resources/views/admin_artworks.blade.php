<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DSgallery: Admin — Artworks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body class="d-flex flex-column" style="min-height:100vh">

<!-- Admin header -->
<nav class="navbar px-4 py-2 border-bottom sticky-top bg-white d-flex justify-content-between">
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/home/logo.png') }}" alt="DSgallery" style="max-height:40px"/>
    </a>
    <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('admin.artworks') }}" class="d-flex align-items-center">
            <div class="search-wrap">
                <input type="text" name="search" placeholder="Search artworks…"
                       value="{{ request('search') }}"/>
                <img class="icon-search" src="{{ asset('icons/search.svg') }}" alt=""/>
            </div>
        </form>
        <span class="mid-btn active">admin</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="mid-btn">Log out</button>
        </form>
    </div>
</nav>

<div class="d-flex flex-grow-1">

    <aside>
        <nav>
            <a class="side-link" href="{{ route('home') }}">Home</a>
            <a class="side-link active" href="{{ route('admin.artworks') }}">Artworks</a>
        </nav>
    </aside>

    <div class="d-flex flex-grow-1">

        <!-- Sort panel -->
        <div class="filter-panel" style="width:160px">
            <p class="muted-label">SORT BY</p>
            <form method="GET" action="{{ route('admin.artworks') }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}"/>
                @endif
                <select name="sort" class="form-select mb-2" style="font-size:13px"
                        onchange="this.form.submit()">
                    <option value="title_asc"  {{ request('sort','title_asc') === 'title_asc'  ? 'selected':'' }}>Title A–Z</option>
                    <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected':'' }}>Price ↑</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected':'' }}>Price ↓</option>
                    <option value="year_asc"   {{ request('sort') === 'year_asc'   ? 'selected':'' }}>Year ↑</option>
                    <option value="year_desc"  {{ request('sort') === 'year_desc'  ? 'selected':'' }}>Year ↓</option>
                </select>
            </form>
        </div>

        <main class="p-4 flex-grow-1" style="overflow-y:auto">

            @if(session('success'))
                <div class="alert alert-success py-2 mb-3" style="font-size:13px">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Artworks
                    <span class="text-muted" style="font-size:16px;font-weight:400">({{ $artworks->total() }})</span>
                </h1>
                <a href="{{ route('admin.add') }}" class="btn btn-dark btn-sm">+ Add artwork</a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">

                @foreach ($artworks as $artwork)
                    <div class="col">
                        <figure class="card p-0 h-100">
                            <a class="img-card" style="height:260px" href="{{ route('admin.detail', $artwork) }}">
                                <img class="art-image" src="{{ asset($artwork->image) }}" alt="{{ $artwork->title }}"/>

                                <!-- Delete button -->
                                <form method="POST" action="{{ route('admin.destroy', $artwork) }}"
                                      onsubmit="return confirm('Delete &quot;{{ $artwork->title }}&quot;?')"
                                style="position:absolute;top:10px;right:10px;z-index:10">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sm-icon-btn delete" title="Delete">
                                    <img src="{{ asset('icons/x.svg') }}" alt="Delete"/>
                                </button>
                                </form>
                            </a>
                            <div class="tile-info">
                                <a href="{{ route('admin.detail', $artwork) }}" class="text-decoration-none text-dark">
                                    <figcaption class="name">{{ $artwork->title }}</figcaption>
                                    <div class="price">{{ number_format($artwork->price, 0) }}€</div>
                                    <div class="text-muted" style="font-size:11px">{{ $artwork->artist }} · {{ $artwork->year }}</div>
                                </a>
                            </div>
                        </figure>
                    </div>
                @endforeach

                <!-- Add artwork card -->
                <div class="col">
                    <a class="add-card" href="{{ route('admin.add') }}">
                        <img src="{{ asset('icons/add.svg') }}" style="width:30px;height:30px"/>
                        <span>Add artwork</span>
                    </a>
                </div>

            </div>

            @if ($artworks->hasPages())
                <nav class="d-flex justify-content-center mt-4">
                    {{ $artworks->links('pagination::bootstrap-5') }}
                </nav>
            @endif

        </main>
    </div>
</div>

@include('footer')

</body>
</html>
