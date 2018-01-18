<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    protected $table = 'item-quantities';

    protected $touches = ['item'];

    public $fillable = [
        'item_id', 'quantity'
    ];


    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
