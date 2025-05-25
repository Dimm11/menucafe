<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\DB;
// Assuming you have a library for Excel export like Maatwebsite/Laravel-Excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport; // You would create this export class

class StaffDashboardController extends Controller
{
    /**
     * Show the staff dashboard.
     */
    public function index(): View
    {
        return view('staff.dashboard'); // Create staff dashboard view in next step
    }

    /**
     * Fetch sales data based on date filters.
     */
    public function fetchSalesData(Request $request): JsonResponse
    {
        $query = WorkOrder::query()
            ->join('work_order_details', 'work_orders.id', '=', 'work_order_details.work_order_id')
            ->select(
                'work_orders.id',
                'work_orders.created_at',
                'work_orders.metode_pembayaran',
                DB::raw('SUM(work_order_details.sub_total) as total_amount')
            )
            ->groupBy('work_orders.id', 'work_orders.created_at', 'work_orders.metode_pembayaran');


        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('work_orders.created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('work_orders.created_at', '<=', $request->end_date);
        }

        $salesData = $query->get();

        return response()->json($salesData);
    }

    /**
     * Export sales data to Excel based on date filters.
     */
    public function exportSalesData(Request $request): BinaryFileResponse
    {
        $query = \App\Models\WorkOrderDetail::query()
            ->join('work_orders', 'work_order_details.work_order_id', '=', 'work_orders.id')
            ->join('products', 'work_order_details.product_id', '=', 'products.id')
            ->select(
                'work_orders.id as order_id',
                'work_orders.created_at as order_date',
                'work_orders.metode_pembayaran',
                'products.nama as product_name',
                'work_order_details.qty',
                'work_order_details.sub_total'
            );

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('work_orders.created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('work_orders.created_at', '<=', $request->end_date);
        }

        $salesData = $query->get();

        // TODO: Implement Excel export using a library like Maatwebsite/Laravel-Excel
        // You would typically create an Export class (e.g., SalesExport)
        return Excel::download(new SalesExport($salesData), 'sales_details_data.xlsx');

        // For now, returning a dummy response or error
        // return response()->file(public_path('dummy_export.xlsx')); // Replace with actual export logic
    }
}
