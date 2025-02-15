@extends('layouts.staff')

@section('content')

    <h1>Product List</h1>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">
        <a href="{{ route('staff.products.create') }}" style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block;">
            Add New Product
        </a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Name</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Description</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Price</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Picture</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Created At</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $product->id }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $product->nama }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $product->deskripsi }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">${{ number_format($product->harga, 2) }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;"><img src="{{ $product->product_pict }}" alt="{{ $product->nama }}" style="max-width: 100px; max-height: 100px;"></td>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $product->created_at }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">
                        <a href="{{ route('staff.products.edit', $product->id) }}" style="margin-right: 5px; text-decoration: none;">Edit</a>
                        <form action="{{ route('staff.products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; color: red; cursor: pointer; padding: 0; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @if ($products->isEmpty())
                <tr>
                    <td colspan="7" style="text-align: center; padding: 10px;">No products created yet.</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection