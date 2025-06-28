<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StaffOrderController extends Controller
{

    public function index(): View
    {
        $orders = WorkOrder::with('workOrderDetails')->latest()->get();

        return view('staff.orders.index', ['orders' => $orders]);
    }

    public function show(WorkOrder $order): View
    {
        $order->load('workOrderDetails.product');

        return view('staff.orders.show', ['order' => $order]); 
    }

    public function updateStatus(Request $request, WorkOrder $order): RedirectResponse 
    {
        $validatedData = $request->validate([
            'status' => 'required|in:Belum Bayar,Sudah Bayar,Canceled,Completed', 
        ]);

        $order->status = $validatedData['status'];
        $order->save();

        return redirect()->route('staff.orders.show', $order->id)->with('success', 'Order status updated successfully!');
    }
}
