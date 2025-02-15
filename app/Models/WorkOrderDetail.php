<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo relationship

class WorkOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id', // Make sure these are fillable for mass assignment
        'product_id',
        'qty',
        'harga',
        'sub_total',
    ];

    /**
     * Get the workOrder that owns the WorkOrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workOrder(): BelongsTo // Method name is singular, related model name
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
        // belongsTo(RelatedModel, foreignKeyOnCurrentTable, ownerKeyOnRelatedTable)
    }

    /**
     * Get the product that owns the WorkOrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo // Method name is singular
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
        // belongsTo(RelatedModel, foreignKeyOnCurrentTable, ownerKeyOnRelatedTable)
    }
}