@extends('layouts.staff') {{-- Use staff layout --}}

    @section('content') {{-- Start content section --}}

        <div class="form-container" style="max-width: 400px; margin-top: 50px;"> {{-- Added form-container class, kept max-width and margin-top --}}
            <h1>Staff Login</h1>

            @if ($errors->any()) {{-- Display validation errors if any --}}
                <div class="alert alert-danger"> {{-- Added alert-danger class --}}
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}"> {{-- Login form --}}
                @csrf {{-- CSRF token --}}

                <div> {{-- Removed inline styles --}}
                    <label for="email">Email:</label> {{-- Removed inline styles --}}
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> {{-- Removed inline styles --}}
                </div>

                <div> {{-- Removed inline styles --}}
                    <label for="password">Password:</label> {{-- Removed inline styles --}}
                    <input id="password" type="password" name="password" required autocomplete="current-password"> {{-- Removed inline styles --}}
                </div>

                <div style="margin-bottom: 15px;"> {{-- Kept margin-bottom for spacing --}}
                    <div style="display: flex; align-items: center;"> {{-- Kept inline styles for layout --}}
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="margin-left: 5px;">Remember Me</label> {{-- Kept margin-left for spacing --}}
                    </div>
                </div>

                <div> {{-- Removed inline styles --}}
                    <button type="submit" class="btn-primary"> {{-- Added btn-primary class, removed inline styles --}}
                        Login
                    </button>
                </div>
            </form>
        </div>

    @endsection
