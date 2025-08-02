<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouse1 = 1;
        $warehouse2 = 2;

        Stock::insert([
            ['inventory_item_id' => 1, 'warehouse_id' => $warehouse1, 'quantity' => 30],
            ['inventory_item_id' => 2, 'warehouse_id' => $warehouse1, 'quantity' => 60],
            ['inventory_item_id' => 3, 'warehouse_id' => $warehouse1, 'quantity' => 5],
            ['inventory_item_id' => 1, 'warehouse_id' => $warehouse2, 'quantity' => 20],
            ['inventory_item_id' => 2, 'warehouse_id' => $warehouse2, 'quantity' => 10],
        ]);
    }
}
