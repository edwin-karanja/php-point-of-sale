<?php

namespace App\Listeners;

use App\Events\QuantityModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Inventory;

class UpdateItemInventory implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  QuantityModified  $event
     * @return void
     */
    public function handle(QuantityModified $event)
    {
        $change = $event->quantity - $event->oldQtty;

        if ($change != 0) {
            Inventory::create([
                'item_id' => $event->item->id,
                'user_id' => $event->user->id,
                'comments' => $event->sale ? 'Sale No#-' . $event->sale->id : 'Manual entry of item quantity',
                'trans_inventory' => $event->quantity - $event->oldQtty
            ]);
        }

    }
}
