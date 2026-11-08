<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Event Registration</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, "Segoe UI", Roboto, sans-serif; background: #f4f6f9; color: #1f2933; }
        header { display: flex; justify-content: space-between; align-items: center; padding: 14px 28px; background: #1d3557; color: #fff; }
        header form { margin: 0; }
        main { max-width: 980px; margin: 32px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 10px; padding: 28px; box-shadow: 0 1px 3px #0001; }
        .narrow { max-width: 400px; margin: 40px auto; }
        label { display: block; margin-bottom: 14px; font-weight: 500; }
        input { display: block; width: 100%; margin-top: 6px; padding: 10px; border: 1px solid #cbd2d9; border-radius: 6px; }
        button { background: #1d3557; color: #fff; border: 0; padding: 10px 18px; border-radius: 6px; cursor: pointer; }
        .btn-outline { background: transparent; border: 1px solid #fff6; padding: 6px 12px; }
        .error { background: #fde8e8; color: #9b1c1c; padding: 10px; border-radius: 6px; }
        .notice { background: #e6f4ea; color: #1e6b35; padding: 10px; border-radius: 6px; }
        .muted { color: #616e7c; }
    </style>
</head>
<body>
    <header>
        <strong>University Event Registration System</strong>
        @auth
            <div>
                {{ auth()->user()->name }} ({{ auth()->user()->role === 'admin' ? 'Administrator' : 'Student' }})
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-outline">Log out</button>
                </form>
            </div>
        @endauth
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>