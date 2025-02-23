@extends('layouts.staff') {{-- Use the staff layout --}}

@section('content') {{-- Start content section --}}

    <h1>Order Details</h1>

    @if (session('success')) {{-- Check for 'success' session message --}}
        <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            {{ session('success') }} {{-- Display success message --}}
        </div>
    @endif

    <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f8f8f8;">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Table Number:</strong> {{ $order->no_meja }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Created At:</strong> {{ $order->created_at }}</p>
        <p><strong>Order Taken By:</strong> {{ $order->nama }}</p> {{-- Assuming 'nama' in work_orders can be staff name if needed --}}
        <p><strong>Work Numbers:</strong> {{ $order->work_numbers }}</p>
        <p><strong>Telephone Number:</strong> {{ $order->no_telp }}</p>
    </div>

    <h2>Order Items</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Product Name</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: right;">Quantity</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: right;">Price</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->workOrderDetails as $detail) {{-- Loop through order details --}}
                <tr>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $detail->product->nama }}</td> {{-- Access product name via relationship --}}
                    <td style="border: 1px solid #ccc; padding: 8px; text-align: right;">{{ $detail->qty }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px; text-align: right;">${{ number_format($detail->harga, 2) }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px; text-align: right;">${{ number_format($detail->sub_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; padding: 8px; font-weight: bold;">Total:</td>
                <td style="border: 1px solid #ccc; padding: 8px; text-align: right; font-weight: bold;">
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

    <div style="margin-top: 30px; border-top: 1px dashed #ccc; padding-top: 20px;">
        <h3>Update Order Status</h3>
        <form method="POST" action="{{ route('staff.orders.status.update', $order->id) }}"> {{-- Form to update status --}}
            @csrf {{-- CSRF token for Laravel forms --}}
            @method('PATCH') {{-- Use PATCH method for updates --}}

            <div style="margin-bottom: 15px;">
                <label for="status">Status:</label>
                <select name="status" id="status" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="belum_bayar" {{ $order->status == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="sudah_bayar" {{ $order->status == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit" style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Update Status</button>
        </form>
    </div>

    <a href="{{ route('staff.orders.index') }}" style="margin-top: 20px; display: inline-block;">Back to Order List</a>
@endsection {{-- End content section --}}