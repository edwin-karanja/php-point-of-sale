<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class SupplierBanking extends Model
{
    protected $fillable = [
        'supplier_id',
        'bank_name',
        'bank_account_number',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
