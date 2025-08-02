<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockTransfer>
 */
class StockTransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fromWarehouse = Warehouse::factory()->create();
        do {
            $toWarehouse = Warehouse::factory()->create();
        } while ($toWarehouse->id === $fromWarehouse->id);

        return [
            'inventory_item_id' => InventoryItem::factory(),
            'from_warehouse_id' => $fromWarehouse->id,
            'to_warehouse_id' => $toWarehouse->id,
            'quantity' => $this->faker->numberBetween(1, 50),
            'transferred_at' => now(),
        ];
    }
}
