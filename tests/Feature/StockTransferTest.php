<?php

namespace Tests\Feature;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_stock_transfer(): void
    {
        $user = User::factory()->create();
        $item = InventoryItem::factory()->create();
        $from = Warehouse::factory()->create();
        $to = Warehouse::factory()->create();

        Stock::create([
            'inventory_item_id' => $item->id,
            'warehouse_id' => $from->id,
            'quantity' => 100,
        ]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/stock-transfers', [
                'inventory_item_id' => $item->id,
                'from_warehouse_id' => $from->id,
                'to_warehouse_id' => $to->id,
                'quantity' => 50,
            ])->assertStatus(201)
              ->assertJson(['message' => 'Stock transferred successfully']);
    }


    public function test_attempting_to_transfer_a_quantity_greater_than_the_available_stock(): void
    {
        $user = User::factory()->create();
        $item = InventoryItem::factory()->create();
        $from = Warehouse::factory()->create();
        $to = Warehouse::factory()->create();

        Stock::create([
            'inventory_item_id' => $item->id,
            'warehouse_id' => $from->id,
            'quantity' => 100,
        ]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/stock-transfers', [
                'inventory_item_id' => $item->id,
                'from_warehouse_id' => $from->id,
                'to_warehouse_id' => $to->id,
                'quantity' => 500,
            ])->assertStatus(422)
              ->assertJson(['message' => 'Insufficient stock to transfer.']);
    }
}
