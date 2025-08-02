<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\LowStockDetected;
use App\Services\StockTransferService;
use App\Models\InventoryItem;
use App\Models\Warehouse;
use App\Models\Stock;


class LowStockEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_event_dispatched(): void
    {
        Log::spy();
        Event::fake([
            LowStockDetected::class,
        ]);

        $item = InventoryItem::factory()->create();
        $fromWarehouse = Warehouse::factory()->create();
        $toWarehouse = Warehouse::factory()->create();

        Stock::create([
            'inventory_item_id' => $item->id,
            'warehouse_id' => $fromWarehouse->id,
            'quantity' => 9,
        ]);

        $service = new StockTransferService();
        $service->transfer([
            'inventory_item_id' => $item->id,
            'from_warehouse_id' => $fromWarehouse->id,
            'to_warehouse_id' => $toWarehouse->id,
            'quantity' => 5,
        ]);

        Event::assertDispatched(LowStockDetected::class);

        $event = new LowStockDetected($item->stocks()->where('warehouse_id', $fromWarehouse->id)->first());
        $listener = new \App\Listeners\NotifyAdminLowStock();
        $listener->handle($event);

        Log::shouldHaveReceived('info')->once();
    }
}
