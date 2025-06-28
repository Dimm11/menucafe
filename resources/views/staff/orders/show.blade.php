@extends('layouts.staff')

@section('content') 

    <h1>Order Details</h1>

    @if (session('success')) 
        <div class="alert alert-success"> 
            {{ session('success') }}
        </div>
    @endif

    <div>
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Table Number:</strong> {{ $order->no_meja }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Created At:</strong> {{ $order->created_at }}</p>
        <p><strong>Order Taken By:</strong> {{ $order->nama }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}</p>
    </div>

    <h2>Order Items</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->workOrderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->nama }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; padding: 8px; font-weight: bold;">Total:</td>
                <td style="border: 1px solid #ccc; padding: 8px; text-align: right; font-weight: bold;">
                    @php
                        $orderTotal = 0;
                        foreach($order->workOrderDetails as $detail) {
                            $orderTotal += $detail->sub_total;
                        }
                    @endphp
                    Rp{{ number_format($orderTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div>
        <h3>Update Order Status</h3>
        <form method="POST" action="{{ route('staff.orders.status.update', $order->id) }}"> {{-- Form to update status --}}
            @csrf {{-- CSRF token for Laravel forms --}}
            @method('PATCH') {{-- Use PATCH method for updates --}}

            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Belum Bayar" {{ $order->status == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="Sudah Bayar" {{ $order->status == 'Sudah Bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="Canceled" {{ $order->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                    <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit">Update Status</button>
        </form>
    </div>

    <a href="{{ route('staff.orders.index') }}">Back to Order List</a>
@endsection {{-- End content section --}}
