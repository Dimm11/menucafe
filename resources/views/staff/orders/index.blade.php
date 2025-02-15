@extends('layouts.staff') {{-- Use the staff layout --}}

@section('content') {{-- Start content section --}}

    <h1>Order List</h1>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Order ID</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Table No.</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Status</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Created At</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Total</th>
                <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order) {{-- Loop through orders passed from controller --}}
                <tr>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->id }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->no_meja }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->status }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->created_at }}</td>
                    <td style="border: 1px solid #ccc; padding: 8px;">
                        {{-- Calculate order total here (you might want to move this logic to the model later) --}}
                        @php
                            $orderTotal = 0;
                            foreach($order->workOrderDetails as $detail) {
                                $orderTotal += $detail->sub_total;
                            }
                        @endphp
                        ${{ number_format($orderTotal, 2) }}
                    </td>
                    <td style="border: 1px solid #ccc; padding: 8px;">
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