<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Order Management</title>
    {{-- Link to your CSS files --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    {{-- Optional: Link Font Awesome if you want icons later --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> --}}
</head>
<body>

    {{-- Sidebar Navigation --}}
    <nav class="sidebar">
        <a href="{{ route('staff.dashboard') }}">Dashboard</a>
        <a href="{{ route('staff.orders.index') }}">Orders</a>
        <a href="{{ route('staff.users.index') }}">Staff Users</a>
        <a href="{{ route('staff.products.index') }}">Products</a>
        {{-- Add more staff navigation links here later --}}
        {{-- Example with optional icon: --}}
        {{-- <a href="#"><i class="fas fa-cog"></i> Settings</a> --}}
        @yield('sidebar-footer') {{-- Section for content at the bottom of the sidebar --}}
    </nav>

    {{-- Main Content Area --}}
    <div class="main-content">
        @yield('content') {{-- Content section for child views --}}
    </div>

</body>
</html>
