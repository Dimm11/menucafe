@extends('layouts.staff')

@section('content')

    <h1>Create New Staff User</h1>

    <div class="form-container"> {{-- Added class for styling --}}
        @if ($errors->any())
            <div class="alert alert-danger"> {{-- Added alert-danger class --}}
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('staff.users.store') }}">
            @csrf

            <div> {{-- Removed inline styles --}}
                <label for="name">Name</label> {{-- Removed inline styles --}}
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="email">Email</label> {{-- Removed inline styles --}}
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="password">Password</label> {{-- Removed inline styles --}}
                <input type="password" class="form-control" id="password" name="password" required> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="password_confirmation">Confirm Password</label> {{-- Removed inline styles --}}
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required> {{-- Removed inline styles --}}
            </div>

            <button type="submit" class="btn btn-primary">Create Staff User</button> {{-- Added btn-primary class, removed inline styles --}}
            <a href="{{ route('staff.users.index') }}" style="margin-left: 10px;">Cancel</a> {{-- Kept margin-left for spacing --}}
        </form>
    </div>

@endsection
