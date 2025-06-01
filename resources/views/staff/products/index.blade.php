@extends('layouts.staff')

@section('content')

    <h1>Product List</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;"> {{-- Kept margin-bottom for spacing --}}
        <a href="{{ route('staff.products.create') }}" class="btn-primary">
            Add New Product
        </a>
    </div>

    <table> {{-- Removed inline styles --}}
        <thead>
            <tr> {{-- Removed inline styles --}}
                <th>ID</th> {{-- Removed inline styles --}}
                <th>Name</th> {{-- Removed inline styles --}}
                <th>Description</th> {{-- Removed inline styles --}}
                <th>Price</th> {{-- Removed inline styles --}}
                <th>Picture</th> {{-- Removed inline styles --}}
                <th>Category</th>
                <th>Created At</th> {{-- Removed inline styles --}}
                <th>Actions</th> {{-- Removed inline styles --}}
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td> {{-- Removed inline styles --}}
                    <td>{{ $product->nama }}</td> {{-- Removed inline styles --}}
                    <td>{{ $product->deskripsi }}</td> {{-- Removed inline styles --}}
                    <td>Rp{{ number_format($product->harga, 0, ',', '.') }}</td> {{-- Removed inline styles --}}
                    <td>
                        @if ($product->product_pict)
                            <img src="{{ asset($product->product_pict) }}" alt="{{ $product->nama }}" style="max-width: 100px; max-height: 100px;" onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=Gambar+Tidak+Ditemukan';">
                        @else
                            <img src="https://placehold.co/100x100?text=Tidak+Ada+Gambar" alt="Tidak Ada Gambar" style="max-width: 100px; max-height: 100px;">
                        @endif
                    </td> {{-- Kept inline style for image size --}}
                    <td>
                        @if ($product->category === 1)
                            Makanan
                        @elseif ($product->category === 2)
                            Minuman
                        @elseif ($product->category === 3)
                            Cemilan
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>{{ $product->created_at }}</td> {{-- Removed inline styles --}}
                    <td> {{-- Removed inline styles --}}
                        <a href="{{ route('staff.products.edit', $product->id) }}" style="margin-right: 5px;">Edit</a> {{-- Kept margin-right for spacing --}}
                        <form action="{{ route('staff.products.delete', $product->id) }}" method="POST" style="display: inline-block;"> {{-- Kept display: inline-block for layout --}}
                            @csrf
                            @method('PUT') {{-- Use PUT method for updating --}}
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button> {{-- Changed button text and class --}}
                        </form>
                    </td>
                </tr>
            @endforeach
            @if ($products->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center; padding: 10px;">No products created yet.</td> {{-- Kept inline styles for empty message --}}
                </tr>
            @endif
        </tbody>
    </table>

@endsection
