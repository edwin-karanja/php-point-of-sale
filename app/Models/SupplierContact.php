<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class SupplierContact extends Model
{
    protected $fillable = [
        'supplier_id',
        'contact_name',
        'contact_phone',
        'contact_email',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
