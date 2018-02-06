<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    protected $fillable = [
        'purchase_id', 'item_id', 'qtty_purchased', 'buying_price', 'selling_price'
    ];
}
