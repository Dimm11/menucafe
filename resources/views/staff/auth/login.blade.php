@extends('layouts.staff')

    @section('content')

        <div class="form-container" style="max-width: 400px; margin-top: 50px; text-align: center;">
            <div style="margin: 0 auto 20px auto;">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="max-width: 150px; height: auto;">
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="text-align: left; margin-bottom: 15px;">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="width: 100%; padding: 8px;">
                </div>

                <div style="text-align: left; margin-bottom: 15px;">
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 8px;">
                </div>

                <div>
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 10px; background-color: black; color: white; border: none; border-radius: 20px; cursor: pointer;">
                        Login
                    </button>
                </div>
            </form>
        </div>

    @endsection
