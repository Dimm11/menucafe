@extends('layouts.staff') {{-- Use the staff layout --}}

@section('content') {{-- Start content section --}}

    <h1>Order List</h1>

    <table class="sales-table">
        <thead class="sales-table-header">
            <tr>
                <th class="sales-table-header-cell">Order ID</th>
                <th class="sales-table-header-cell">Table No.</th>
                <th class="sales-table-header-cell">Status</th>
                <th class="sales-table-header-cell">Metode Pembayaran</th>
                <th class="sales-table-header-cell">Created At</th>
                <th class="sales-table-header-cell">Total</th>
                <th class="sales-table-header-cell">Actions</th>
            </tr>
        </thead>
        <tbody class="sales-table-body">
            @foreach($orders as $order) {{-- Loop through orders passed from controller --}}
                <tr>
                    <td class="sales-table-data-cell">{{ $order->id }}</td>
                    <td class="sales-table-data-cell">{{ $order->no_meja }}</td>
                    <td class="sales-table-data-cell">{{ $order->status }}</td>
                    <td class="sales-table-data-cell">{{ $order->metode_pembayaran }}</td>
                    <td class="sales-table-data-cell">{{ $order->created_at }}</td>
                    <td class="sales-table-data-cell">
                        {{-- Calculate order total here (you might want to move this logic to the model later) --}}
                        @php
                            $orderTotal = 0;
                            foreach($order->workOrderDetails as $detail) {
                                $orderTotal += $detail->sub_total;
                            }
                        @endphp
                        Rp{{ number_format($orderTotal, 0, ',', '.') }}
                    </td>
                    <td>
                        <a href="{{ route('staff.orders.show', $order->id) }}">View Details</a>                    </td>
                </tr>
            @endforeach
            @if ($orders->isEmpty()) {{-- Display message if no orders --}}
                <tr>
                    <td colspan="7" style="text-align: center; padding: 10px;">No orders yet.</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection {{-- End content section --}}
