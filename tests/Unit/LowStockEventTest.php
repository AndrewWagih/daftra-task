<?php

namespace Tests\Unit;

use App\Events\LowStockDetected;
use App\Models\Stock;
use Tests\TestCase;

class LowStockEventTest extends TestCase
{
     public function test_event_stores_stock_instance(): void
    {
        $stock = new Stock([
            'inventory_item_id' => 1,
            'warehouse_id' => 1,
            'quantity' => 2,
        ]);

        $event = new LowStockDetected($stock);

        $this->assertSame($stock, $event->stock);
    }
}
