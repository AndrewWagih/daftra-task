<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use App\Listeners\NotifyAdminLowStock;
use App\Events\LowStockDetected;
use App\Models\Stock;
class NotifyAdminLowStockTest extends TestCase
{
    public function test_listener_logs_low_stock_info(): void
    {
        Log::spy();

        $stock = new Stock([
            'inventory_item_id' => 5,
            'warehouse_id' => 2,
            'quantity' => 3,
        ]);

        $event = new LowStockDetected($stock);
        $listener = new NotifyAdminLowStock();
        $listener->handle($event);

        Log::shouldHaveReceived('info')->withArgs(function ($message, $context) use ($stock) {
            return $message === 'Low stock detected' &&
                $context['item_id'] === $stock->inventory_item_id &&
                $context['warehouse_id'] === $stock->warehouse_id &&
                $context['quantity'] === $stock->quantity;
        })->once();
    }
}
