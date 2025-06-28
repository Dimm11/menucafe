@php
    use Illuminate\Support\Facades\Route;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Order Management</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> --}}
</head>
<body>

    @unless(Route::is('login'))
    <nav class="sidebar">
        <a href="{{ route('staff.dashboard') }}">Dashboard</a>
        <a href="{{ route('staff.orders.index') }}">Orders</a>
        <a href="{{ route('staff.users.index') }}">Staff Users</a>
        <a href="{{ route('staff.products.index') }}">Products</a>
        {{-- <a href="#"><i class="fas fa-cog"></i> Settings</a> --}}
        @yield('sidebar-footer')
        <div class="sidebar-footer">
            <form action="{{ route('staff.logout') }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px; background-color: #f44336; color: white; border: none; cursor: pointer;">Logout</button>
            </form>
        </div>
    </nav>
    @endunless

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>
