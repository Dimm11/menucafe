<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StaffOrderController extends Controller
{
    /**
     * Display a listing of work orders for staff.
     */
    public function index(): View
    {
        $orders = WorkOrder::with('workOrderDetails')->latest()->get();

        return view('staff.orders.index', ['orders' => $orders]);
    }

    /**
     * Display the specified work order details.
     */
    public function show(WorkOrder $order): View // Route model binding - Laravel automatically injects the WorkOrder model based on the ID
    {
        $order->load('workOrderDetails.product'); // Eager load workOrderDetails and their related products for efficiency

        return view('staff.orders.show', ['order' => $order]); // Pass the single $order to the detail view
    }

    public function updateStatus(Request $request, WorkOrder $order): RedirectResponse // Route Model Binding for $order, Request for input
    {
        // 1. Validate the incoming status value
        $validatedData = $request->validate([
            'status' => 'required|in:pending,preparing,served,completed', // Validate that status is one of the allowed enum values
        ]);

        // 2. Update the order's status
        $order->status = $validatedData['status']; // Set the new status from validated data
        $order->save(); // Save the updated WorkOrder

        // 3. Redirect back to the order details page with a success message
        return redirect()->route('staff.orders.show', $order->id)->with('success', 'Order status updated successfully!');
        // RedirectResponse, back to order details, with a success message stored in the session
    }
}