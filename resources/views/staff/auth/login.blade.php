@extends('layouts.staff') {{-- Use staff layout --}}

    @section('content') {{-- Start content section --}}

        <div style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; margin-top: 50px;">
            <h1>Staff Login</h1>

            @if ($errors->any()) {{-- Display validation errors if any --}}
                <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}"> {{-- Login form --}}
                @csrf {{-- CSRF token --}}

                <div style="margin-bottom: 15px;">
                    <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                </div>

                <div style="margin-bottom: 15px;">
                    <div style="display: flex; align-items: center;">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="margin-left: 5px;">Remember Me</label>
                    </div>
                </div>

                <div>
                    <button type="submit" style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Login
                    </button>
                </div>
            </form>
        </div>

    @endsection