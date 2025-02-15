<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany relationship

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_telp',
        'no_meja',
        'status',
        'work_numbers',
    ];

    /**
     * Get all of the workOrderDetails for the WorkOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workOrderDetails(): HasMany // Method name is plural
    {
        return $this->hasMany(WorkOrderDetail::class, 'work_order_id', 'id');
        // hasMany(RelatedModel, foreignKeyOnRelatedTable, localKeyOnCurrentTable)
    }
}