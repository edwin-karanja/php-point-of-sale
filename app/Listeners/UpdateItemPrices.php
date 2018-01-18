<?php

namespace App\Listeners;

use App\Events\PricesModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Item;

class UpdateItemPrices implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  PricesModified  $event
     * @return void
     */
    public function handle(PricesModified $event)
    {
        $item = Item::find($event->item['id']);

        $item->update([
            'buying_price' => $event->item['buying_price'],
            'selling_price' => $event->item['selling_price']
        ]);
    }
}
