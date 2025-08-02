<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InventoryItem::insert([
            ['name' => 'Item A', 'sku' => 'SKU-A1', 'price' => 50.00],
            ['name' => 'Item B', 'sku' => 'SKU-B1', 'price' => 75.00],
            ['name' => 'Item C', 'sku' => 'SKU-C1', 'price' => 100.00],
        ]);
    }
}
