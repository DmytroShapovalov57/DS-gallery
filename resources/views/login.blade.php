<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DSgallery: Log in</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body class="d-flex flex-column" style="min-height:100vh">



<div class="d-flex flex-grow-1">
    <aside>
        <nav>
            <a class="side-link" href="{{ route('home') }}">Home</a>
            <a class="side-link" href="{{ route('artworks') }}">Artworks</a>
        </nav>
    </aside>

    <main class="d-flex justify-content-center p-4 flex-grow-1">
        <div style="width:100%;max-width:400px">

            <h1 class="mb-3">Log in</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Email</label>
                    <input class="form-control" type="email" name="email"
                           placeholder="your@email.com" value="{{ old('email') }}"/>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="••••••••"/>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 mb-3" style="font-size:13px">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="btn btn-dark w-100 mb-3">Log in</button>
            </form>

            <p class="text-center text-muted small">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-dark fw-semibold text-decoration-none">Register</a>
            </p>
        </div>
    </main>
</div>



</body>
</html>
