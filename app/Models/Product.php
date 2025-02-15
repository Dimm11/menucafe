<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany relationship

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ // Allow mass assignment for these fields
        'nama',
        'deskripsi',
        'harga',
        'product_pict',
    ];

    /**
     * Get all of the workOrderDetails for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workOrderDetails(): HasMany // Method name is usually the plural of the related model
    {
        return $this->hasMany(WorkOrderDetail::class, 'product_id', 'id');
        // hasMany(RelatedModel, foreignKeyOnRelatedTable, localKeyOnCurrentTable)
    }
}