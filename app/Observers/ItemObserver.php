<?php

namespace App\Observers;

use App\Helpers\Cache\ItemsCache;
use App\Models\Item;

class ItemObserver
{
    protected $cache;

    public function __construct(ItemsCache $cache)
    {
        $this->cache = $cache;
    }
    /**
     * Handle to the item "created" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function created(Item $item)
    {
        $this->cache->clearCache('grouped-items');
    }

    /**
     * Handle the item "updated" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function updated(Item $item)
    {
        $this->cache->clearCache('grouped-items');
    }

    /**
     * Handle the item "deleted" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function deleted(Item $item)
    {
        $this->cache->clearCache('grouped-items');
    }
}
