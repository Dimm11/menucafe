@extends('layouts.staff')

@section('content')

    <h1>Staff Users</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;"> {{-- Kept margin-bottom for spacing --}}
        <a href="{{ route('staff.users.create') }}" class="btn-primary">
            Add New Staff User
        </a>
    </div>

    <table> {{-- Removed inline styles --}}
        <thead>
            <tr> {{-- Removed inline styles --}}
                <th>ID</th> {{-- Removed inline styles --}}
                <th>Name</th> {{-- Removed inline styles --}}
                <th>Email</th> {{-- Removed inline styles --}}
                <th>Created At</th> {{-- Removed inline styles --}}
                <th>Actions</th> {{-- Removed inline styles --}}
            </tr>
        </thead>
        <tbody>
            @foreach($staffUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td> {{-- Removed inline styles --}}
                    <td>{{ $user->name }}</td> {{-- Removed inline styles --}}
                    <td>{{ $user->email }}</td> {{-- Removed inline styles --}}
                    <td>{{ $user->created_at }}</td> {{-- Removed inline styles --}}
                    <td> {{-- Removed inline styles --}}
                        <a href="{{ route('staff.users.edit', $user->id) }}" style="margin-right: 5px;">Edit</a> {{-- Kept margin-right for spacing --}}
                        <form action="{{ route('staff.users.destroy', $user->id) }}" method="POST" style="display: inline-block;"> {{-- Kept display: inline-block for layout --}}
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to delete this staff user?')">Delete</button> {{-- Added btn-danger class --}}
                        </form>
                    </td>
                </tr>
            @endforeach
            @if ($staffUsers->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center; padding: 10px;">No staff users created yet.</td> {{-- Kept inline styles for empty message --}}
                </tr>
            @endif
        </tbody>
    </table>

@endsection
