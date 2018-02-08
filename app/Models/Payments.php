<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    public $fillable = ['sale_id', 'sale_total', 'amount_paid', 'balance_due'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
