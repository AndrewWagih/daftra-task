<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sku', 'price'];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function warehouses()
    {
        return $this->hasManyThrough(Warehouse::class, Stock::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(StockTransfer::class);
    }
}
