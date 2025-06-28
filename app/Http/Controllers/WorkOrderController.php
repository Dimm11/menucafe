<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class WorkOrderController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        Log::info('WorkOrderController@store started.'); 
        $validatedData = $request->validate([
            'table_number' => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:QRIS,Tunai', 
            'cart_items' => 'required|array',            
            'cart_items.*.name' => 'required|string',   
            'cart_items.*.price' => 'required|numeric|min:0', 
            'cart_items.*.quantity' => 'required|integer|min:1',
        ]);

        Log::info('Data validated successfully.', ['validatedData' => $validatedData]); 
        Log::info('Creating new WorkOrder record.');
        $workOrder = new WorkOrder();
        $workOrder->nama = 'Cafe Order - Table ' . $validatedData['table_number']; 
        $workOrder->no_meja = $validatedData['table_number'];
        $workOrder->status = 'Belum Bayar'; 
        $workOrder->metode_pembayaran = $validatedData['metode_pembayaran'];
        $workOrder->save();

        Log::info('WorkOrder saved successfully.', ['workOrderId' => $workOrder->id]);

        Log::info('Processing cart items.', ['cartItemsCount' => count($validatedData['cart_items'])]); 
        foreach ($validatedData['cart_items'] as $cartItem) {
            Log::info('Processing cart item:', ['cartItem' => $cartItem]); 
            $product = Product::where('nama', $cartItem['name'])->first();
            $product = Product::where('nama', $cartItem['name'])->first();
            Log::info('Product search result:', ['product' => $product]);
            if ($product) {
                Log::info('Creating new WorkOrderDetail record.');
                $workOrderDetail = new WorkOrderDetail();
                $workOrderDetail->work_order_id = $workOrder->id;
                $workOrderDetail->product_id = $product->id;
                $workOrderDetail->qty = $cartItem['quantity'];
                $workOrderDetail->harga = $cartItem['price'];
                $workOrderDetail->sub_total = $cartItem['price'] * $cartItem['quantity'];
                $workOrderDetail->save();
                Log::info('WorkOrderDetail saved successfully.', ['workOrderDetailId' => $workOrderDetail->id]);
            } else {
                Log::warning('Product not found for cart item:', ['cartItemName' => $cartItem['name']]);
            }
        }

        Log::info('WorkOrderController@store finished successfully.', ['orderId' => $workOrder->id]);
        return response()->json(['message' => 'Order placed successfully!', 'order_id' => $workOrder->id], 201);
    }
}
