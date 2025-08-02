<?php
namespace App\Services;

use App\Events\LowStockDetected;
use App\Exceptions\InsufficientStockException;
use App\Models\Stock;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\DB;

class StockTransferService
{
    public function transfer(array $data): void
    {
        DB::transaction(function () use ($data) {
            $stock = Stock::where('inventory_item_id', $data['inventory_item_id'])
                ->where('warehouse_id', $data['from_warehouse_id'])
                ->lockForUpdate()
                ->first();

            if (! $stock || $stock->quantity < $data['quantity']) {
                throw new InsufficientStockException('Insufficient stock to transfer.',422);
            }

            $stock->decrement('quantity', $data['quantity']);

            $toStock = Stock::firstOrCreate(
                [
                    'inventory_item_id' => $data['inventory_item_id'],
                    'warehouse_id' => $data['to_warehouse_id']
                ],
                ['quantity' => 0]
            );

            $toStock->increment('quantity', $data['quantity']);

            StockTransfer::create([
                ...$data,
                'transferred_at' => now()
            ]);

            if ($stock->quantity < 10) {
                event(new LowStockDetected($stock));
            }
        });
    }
}
