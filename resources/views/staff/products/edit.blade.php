@extends('layouts.staff')

@section('content')

    <h1>Edit Product</h1>

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

        <form method="POST" action="{{ route('staff.products.update', $product->id) }}">
            @csrf
            @method('PATCH')

            <div style="margin-bottom: 15px;">
                <label for="nama" style="display: block; margin-bottom: 5px;">Name</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $product->nama) }}" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="deskripsi" style="display: block; margin-bottom: 5px;">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="harga" style="display: block; margin-bottom: 5px;">Price</label>
                <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" required step="0.01" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="product_pict" style="display: block; margin-bottom: 5px;">Product Picture URL (Optional)</label>
                <input type="url" class="form-control" id="product_pict" name="product_pict" value="{{ old('product_pict', $product->product_pict) }}" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Update Product</button>
            <a href="{{ route('staff.products.index') }}" style="margin-left: 10px; text-decoration: none;">Cancel</a>
        </form>
    </div>

@endsection