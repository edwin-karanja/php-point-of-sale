<?php

namespace App\Observers;

use App\Helpers\Cache\ItemsCache;
use App\Models\Quantity;

class QuantityObserver
{
    protected $cache;

    public function __construct(ItemsCache $cache)
    {
        $this->cache = $cache;
    }
    /**
     * Handle to the quantity "created" event.
     *
     * @param  \App\Models\Quantity  $quantity
     * @return void
     */
    public function created(Quantity $quantity)
    {
        $this->cache->clearCache('grouped-items');
    }

    /**
     * Handle the quantity "updated" event.
     *
     * @param  \App\Models\Quantity  $quantity
     * @return void
     */
    public function updated(Quantity $quantity)
    {
        $this->cache->clearCache('grouped-items');
    }

    /**
     * Handle the quantity "deleted" event.
     *
     * @param  \App\Models\Quantity  $quantity
     * @return void
     */
    public function deleted(Quantity $quantity)
    {
        $this->cache->clearCache('grouped-items');
    }
}
