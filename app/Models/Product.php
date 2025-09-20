<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'stock_quantity',
        'reorder_level',
    ];

    // Check if stock is below reorder level
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->reorder_level;
    }
    
}
