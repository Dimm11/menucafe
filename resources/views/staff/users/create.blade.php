@extends('layouts.staff')

@section('content')

    <h1>Create New Staff User</h1>

    <div style="max-width: 600px; margin-top: 20px;">
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('staff.users.store') }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; margin-bottom: 5px;">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px;">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password" style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" class="form-control" id="password" name="password" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 5px;">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Create Staff User</button>
            <a href="{{ route('staff.users.index') }}" style="margin-left: 10px; text-decoration: none;">Cancel</a>
        </form>
    </div>

@endsection