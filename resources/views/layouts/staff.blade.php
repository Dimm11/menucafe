<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Order Management</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> {{-- Link to your existing CSS (or create separate staff CSS later) --}}
</head>
<body>

    <nav style="background-color: #f0f0f0; padding: 10px; margin-bottom: 20px;">
        <a href="{{ route('staff.dashboard') }}" style="margin-right: 20px;">Dashboard</a>
        <a href="{{ route('staff.orders.index') }}" style="margin-right: 20px;">Orders</a>
        <a href="{{ route('staff.users.index') }}" style="margin-right: 20px;">Staff Users</a>
        <a href="{{ route('staff.products.index') }}" style="margin-right: 20px;">Products</a>
        <!-- Add more staff navigation links here later -->
    </nav>

    <div class="container" style="padding: 20px;">
        @yield('content') {{-- Content section for child views --}}
    </div>

</body>
</html>