<?php

namespace App\Listeners;

use App\Events\QuantityModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Quantity;

class UpdateQuantity implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  QuantityModified  $event
     * @return void
     */
    public function handle(QuantityModified $event)
    {
        Quantity::updateOrCreate(
            ['item_id' => $event->item->id],
            ['quantity' => $event->quantity]
        );
    }
}
