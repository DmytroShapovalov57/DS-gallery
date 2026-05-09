<aside>
    <nav>
        <a class="side-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>

        @if(auth()->check() && auth()->user()->is_admin)
            <a class="side-link {{ Route::is('admin.artworks') ? 'active' : '' }}" href="{{ route('admin.artworks') }}">Artworks</a>
        @else
            <a class="side-link {{ Route::is('artworks') ? 'active' : '' }}" href="{{ route('artworks') }}">Artworks</a>
        @endif
    </nav>
</aside>
