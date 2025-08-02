<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class WarehouseInventoryController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $inventory = Cache::remember("warehouse_inventory_{$id}", 60, function () use ($id) {
            return Warehouse::with(['stocks.inventoryItem'])->findOrFail($id)->stocks->map(function ($stock) {
                return [
                    'item' => $stock->inventoryItem->name,
                    'sku' => $stock->inventoryItem->sku,
                    'quantity' => $stock->quantity,
                    'price' => $stock->inventoryItem->price,
                ];
            });
        });

        return response()->json(['data' => $inventory]);
    }
}
