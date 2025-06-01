@extends('layouts.staff')

@section('content')

    <h1>Edit Product</h1>

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

        <form method="POST" action="{{ route('staff.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div>
                <label for="nama" class="form-label">Name</label>
                <input type="text" class="form-input" id="nama" name="nama" value="{{ old('nama', $product->nama) }}" required>
            </div>

            <div>
                <label for="deskripsi" class="form-label">Description</label>
                <textarea class="form-input" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="harga" class="form-label">Price</label>
                <input type="number" class="form-input" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" required step="0.01">
            </div>

            <div>
                <label for="image" class="form-label">Product Image</label>
                @if ($product->product_pict)
                    <img src="{{ asset($product->product_pict) }}" alt="Product Image" style="max-width: 200px; margin-top: 10px;">
                @endif
                <input type="file" class="form-input" id="image" name="image" accept="image/*">
            </div>

            <div>
                <label for="category" class="form-label">Category</label>
                <select class="form-input" id="category" name="category">
                    <option value="">Select Category</option>
                    <option value="1" {{ old('category', $product->category) == 1 ? 'selected' : '' }}>Makanan</option>
                    <option value="2" {{ old('category', $product->category) == 2 ? 'selected' : '' }}>Minuman</option>
                    <option value="3" {{ old('category', $product->category) == 3 ? 'selected' : '' }}>Cemilan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('staff.products.index') }}" style="margin-left: 10px;">Cancel</a> {{-- Kept margin-left for spacing --}}
        </form>
    </div>

@endsection
