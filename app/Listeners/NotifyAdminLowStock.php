<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminLowStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockDetected $event): void
    {
        logger()->info('Low stock detected', [
            'item_id' => $event->stock->inventory_item_id,
            'warehouse_id' => $event->stock->warehouse_id,
            'quantity' => $event->stock->quantity,
        ]);
    }
}
