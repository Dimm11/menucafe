@extends('layouts.staff') {{-- Use staff layout --}}

@section('content') {{-- Start content section --}}

    <h1>Staff Dashboard</h1>

    <div style="margin-bottom: 20px;">
        <p>Welcome, {{ Auth::guard('staff')->user()->name }}!</p> {{-- Display logged-in staff name --}}
        <p>You are logged in as a staff member.</p>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('staff.orders.index') }}" style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-block;">View Orders</a> {{-- Link to Order List --}}
    </div>

    <form method="POST" action="{{ route('staff.logout') }}"> {{-- Logout form --}}
        @csrf {{-- CSRF token --}}
        <button type="submit" style="padding: 10px 15px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Logout</button> {{-- Logout button --}}
    </form>

@endsection {{-- End content section --}}