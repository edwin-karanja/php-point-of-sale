<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Item;
use App\Models\User;

class QuantityModified
{
    use Dispatchable, SerializesModels;

    public $item;

    public $user;

    public $quantity;

    public $oldQtty;

    public $sale;

    public $model;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Item $item, User $user, $quantity, $oldQtty = null, $sale = null, $model = 'default')
    {
        $this->quantity = $quantity;

        $this->item = $item;

        $this->user = $user;

        $this->oldQtty = $oldQtty;

        $this->sale = $sale;

        $this->model = $model;
    }
}
