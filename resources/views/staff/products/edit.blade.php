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

        <form method="POST" action="{{ route('staff.products.update', $product->id) }}">
            @csrf
            @method('PATCH')

            <div> {{-- Removed inline styles --}}
                <label for="nama">Name</label> {{-- Removed inline styles --}}
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $product->nama) }}" required> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="deskripsi">Description</label> {{-- Removed inline styles --}}
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="harga">Price</label> {{-- Removed inline styles --}}
                <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" required step="0.01"> {{-- Removed inline styles --}}
            </div>

            <div> {{-- Removed inline styles --}}
                <label for="product_pict">Product Picture URL (Optional)</label> {{-- Removed inline styles --}}
                <input type="url" class="form-control" id="product_pict" name="product_pict" value="{{ old('product_pict', $product->product_pict) }}"> {{-- Removed inline styles --}}
            </div>

            <div>
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="">Select Category</option>
                    <option value="1" {{ old('category', $product->category) == 1 ? 'selected' : '' }}>1 Makanan</option>
                    <option value="2" {{ old('category', $product->category) == 2 ? 'selected' : '' }}>2 Minuman</option>
                    <option value="3" {{ old('category', $product->category) == 3 ? 'selected' : '' }}>3 Cemilan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button> {{-- Added btn-primary class, removed inline styles --}}
            <a href="{{ route('staff.products.index') }}" style="margin-left: 10px;">Cancel</a> {{-- Kept margin-left for spacing --}}
        </form>
    </div>

@endsection
