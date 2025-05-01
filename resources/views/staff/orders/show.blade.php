@extends('layouts.staff') {{-- Use the staff layout --}}

@section('content') {{-- Start content section --}}

    <h1>Order Details</h1>

    @if (session('success')) {{-- Check for 'success' session message --}}
        <div class="alert alert-success"> {{-- Using a common class for alerts --}}
            {{ session('success') }} {{-- Display success message --}}
        </div>
    @endif

    <div> {{-- Removed inline styles --}}
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Table Number:</strong> {{ $order->no_meja }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Created At:</strong> {{ $order->created_at }}</p>
        <p><strong>Order Taken By:</strong> {{ $order->nama }}</p> {{-- Assuming 'nama' in work_orders can be staff name if needed --}}
        <p><strong>Work Numbers:</strong> {{ $order->work_numbers }}</p>
        <p><strong>Telephone Number:</strong> {{ $order->no_telp }}</p>
    </div>

    <h2>Order Items</h2>
    <table> {{-- Removed inline styles --}}
        <thead>
            <tr> {{-- Removed inline styles --}}
                <th>Product Name</th> {{-- Removed inline styles --}}
                <th>Quantity</th> {{-- Removed inline styles --}}
                <th>Price</th> {{-- Removed inline styles --}}
                <th>Subtotal</th> {{-- Removed inline styles --}}
            </tr>
        </thead>
        <tbody>
            @foreach($order->workOrderDetails as $detail) {{-- Loop through order details --}}
                <tr>
                    <td>{{ $detail->product->nama }}</td> {{-- Access product name via relationship --}}
                    <td>{{ $detail->qty }}</td>
                    <td>${{ number_format($detail->harga, 2) }}</td>
                    <td>${{ number_format($detail->sub_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; padding: 8px; font-weight: bold;">Total:</td> {{-- Kept inline style for total alignment --}}
                <td style="border: 1px solid #ccc; padding: 8px; text-align: right; font-weight: bold;"> {{-- Kept inline style for total alignment and border --}}
                    {{-- Calculate total again, ensure consistency --}}
                    @php
                        $orderTotal = 0;
                        foreach($order->workOrderDetails as $detail) {
                            $orderTotal += $detail->sub_total;
                        }
                    @endphp
                    ${{ number_format($orderTotal, 2) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div> {{-- Removed inline styles --}}
        <h3>Update Order Status</h3>
        <form method="POST" action="{{ route('staff.orders.status.update', $order->id) }}"> {{-- Form to update status --}}
            @csrf {{-- CSRF token for Laravel forms --}}
            @method('PATCH') {{-- Use PATCH method for updates --}}

            <div> {{-- Removed inline styles --}}
                <label for="status">Status:</label>
                <select name="status" id="status"> {{-- Removed inline styles --}}
                    <option value="belum_bayar" {{ $order->status == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="sudah_bayar" {{ $order->status == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit">Update Status</button> {{-- Removed inline styles --}}
        </form>
    </div>

    <a href="{{ route('staff.orders.index') }}">Back to Order List</a> {{-- Removed inline styles --}}
@endsection {{-- End content section --}}
