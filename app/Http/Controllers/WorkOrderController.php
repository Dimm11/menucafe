<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Import JsonResponse

class WorkOrderController extends Controller
{
    /**
     * Store a newly created work order (from public menu order).
     */
    public function store(Request $request): JsonResponse // Expecting JSON request, returning JSON response
    {
        // 1. Validate incoming data
        $validatedData = $request->validate([
            'table_number' => 'required|string|max:20', // Example validation for table number
            'cart_items' => 'required|array',             // Cart items must be an array
            'cart_items.*.name' => 'required|string',    // Each cart item must have a name
            'cart_items.*.price' => 'required|numeric|min:0', // Each item must have a valid price
            'cart_items.*.quantity' => 'required|integer|min:1', // Each item quantity must be at least 1
        ]);

        // 2. Create a new WorkOrder record
        $workOrder = new WorkOrder();
        $workOrder->nama = 'Cafe Order - Table ' . $validatedData['table_number']; // You can customize order name
        $workOrder->no_meja = $validatedData['table_number'];
        $workOrder->status = 'pending'; // Default status for new orders (you can define statuses in migration or enum)
        // You might want to set other WorkOrder fields (nama, no_telp, work_numbers) based on your needs
        $workOrder->save(); // Save the WorkOrder to get an ID

        // 3. Create WorkOrderDetail records for each item in the cart
        foreach ($validatedData['cart_items'] as $cartItem) {
            $product = Product::where('nama', $cartItem['name'])->first(); // Find product by name
            if ($product) {
                $workOrderDetail = new WorkOrderDetail();
                $workOrderDetail->work_order_id = $workOrder->id; // Associate with the WorkOrder
                $workOrderDetail->product_id = $product->id;      // Associate with the Product
                $workOrderDetail->qty = $cartItem['quantity'];
                $workOrderDetail->harga = $cartItem['price'];      // Store price at time of order
                $workOrderDetail->sub_total = $cartItem['price'] * $cartItem['quantity'];
                $workOrderDetail->save();
            }
            // You could add error handling here if a product is not found by name
        }

        // 4. Return a JSON response indicating success
        return response()->json(['message' => 'Order placed successfully!', 'order_id' => $workOrder->id], 201); // 201 Created status code
    }
}