<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class SupplierMeta extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_account_number',
        'supplier_id',
        'contact_name',
        'contact_phone',
        'contact_email',
        'notes'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
