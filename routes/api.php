<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StockTransferController;
use App\Http\Controllers\API\WarehouseInventoryController;
use App\Http\Controllers\API\InventoryItemController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/stock-transfers', [StockTransferController::class, 'store']);
});

Route::get('/inventory', [InventoryItemController::class, 'index']);
Route::get('/warehouses/{id}/inventory', [WarehouseInventoryController::class, 'show']);

Route::get('test',function(){
    $Warehouse = \App\Models\Warehouse::factory()->create();
    dd($Warehouse);
});