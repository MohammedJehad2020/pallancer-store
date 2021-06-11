<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PalLancer-Store</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @stack('css')
</head>

<body>


    <header class="py-2 bg-dark text-white mb-4">
        <div class="class container">
            <div class="d-flex">
                <h1 class="h3">{{ config('app.name') }}</h1>

               {{-- @if(Auth::check()) --}}
               @auth
                <div class="ms-auto">
                    Hi, {{ Auth::user()->name}}
                    <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
                    <form id="logout" class="d-none" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </header>
    <div class="class container">
        <div class="row">
            <aside class="col-md-3">
                <h4>Navigation Menu</h4>
                <nav>
                    <!-- use to nav active -->
                    <!--nav-link @if(request()->routeIs('admin.categories.*')) active @endif -->
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a href="{{ route('admin.categories.dashboard') }}" class="nav-link {{ Request::is('admin/categories/dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li class="nav-item"><a href="{{ route('admin.categories.index') }}" class="nav-link {{ Request::is('admin/categories') ? 'active' : '' }}">Categories</a></li>
                        <li class="nav-item"><a href="{{ route('admin.categories.product') }}" class="nav-link {{ Request::is('admin/categories/product') ? 'active' : '' }}">Products</a></li>
                    </ul>
                </nav>
            </aside>
            <main class="col-md-9">
                <div class="mb-4">
                    <h3 class="text-primary">
                        {{ $title ?? 'Default Title' }}
                        <!-- @yield('title', 'fdfdfdfd') -->
                    </h3>
                </div>

                <!-- @yield('content') -->
                {{ $slot }}

            </main>
        </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
    @stack('js')
</body>

</html>