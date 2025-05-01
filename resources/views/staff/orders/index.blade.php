@extends('layouts.staff') {{-- Use the staff layout --}}

@section('content') {{-- Start content section --}}

    <h1>Order List</h1>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Table No.</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order) {{-- Loop through orders passed from controller --}}
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->no_meja }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        {{-- Calculate order total here (you might want to move this logic to the model later) --}}
                        @php
                            $orderTotal = 0;
                            foreach($order->workOrderDetails as $detail) {
                                $orderTotal += $detail->sub_total;
                            }
                        @endphp
                        ${{ number_format($orderTotal, 2) }}
                    </td>
                    <td>
                        <a href="{{ route('staff.orders.show', $order->id) }}">View Details</a>                    </td>
                </tr>
            @endforeach
            @if ($orders->isEmpty()) {{-- Display message if no orders --}}
                <tr>
                    <td colspan="6" style="text-align: center; padding: 10px;">No orders yet.</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection {{-- End content section --}}
