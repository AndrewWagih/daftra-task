<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\StockTransferService;
use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;

class StockTransferUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_transfer_stock(): void
    {
        $item = InventoryItem::factory()->create();
        $from = Warehouse::factory()->create();
        $to = Warehouse::factory()->create();

        Stock::create([
            'inventory_item_id' => $item->id,
            'warehouse_id' => $from->id,
            'quantity' => 20,
        ]);

        $service = new StockTransferService();

        $service->transfer([
            'inventory_item_id' => $item->id,
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => $to->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('stocks', [
            'inventory_item_id' => $item->id,
            'warehouse_id' => $from->id,
            'quantity' => 15,
        ]);

        $this->assertDatabaseHas('stocks', [
            'inventory_item_id' => $item->id,
            'warehouse_id' => $to->id,
            'quantity' => 5,
        ]);
    }

    public function test_cannot_transfer_more_than_available(): void
    {
        $item = InventoryItem::factory()->create();
        $from = Warehouse::factory()->create();
        Stock::create([
            'inventory_item_id' => $item->id,
            'warehouse_id' => $from->id,
            'quantity' => 5,
        ]);

        $service = new StockTransferService();

        $this->expectException(Exception::class);

        $service->transfer([
            'inventory_item_id' => $item->id,
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => Warehouse::factory()->create()->id,
            'quantity' => 50,
        ]);

    }

}
