@extends('layouts.staff')

@section('content')

    <h1>Create New Product</h1>

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

        <form method="POST" action="{{ route('staff.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div> {{-- Removed inline styles --}}
                <label for="nama">Name</label> {{-- Removed inline styles --}}
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="deskripsi">Description</label> {{-- Removed inline styles --}}
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="harga">Price</label> {{-- Removed inline styles --}}
                <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required step="0.01"> {{-- Removed inline styles --}}
            </div>

            <div>
                <label for="image">Product Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div>
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="">Select Category</option>
                    <option value="1" {{ old('category') == 1 ? 'selected' : '' }}>Makanan</option>
                    <option value="2" {{ old('category') == 2 ? 'selected' : '' }}>Minuman</option>
                    <option value="3" {{ old('category') == 3 ? 'selected' : '' }}>Cemilan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Product</button> {{-- Added btn-primary class, removed inline styles --}}
            <a href="{{ route('staff.products.index') }}" style="margin-left: 10px;">Cancel</a> {{-- Kept margin-left for spacing --}}
        </form>
    </div>

@endsection
