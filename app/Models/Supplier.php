<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SupplierMeta;

class Supplier extends Model
{
    protected $fillable = ['name', 'description', 'total_supplied_amount', 'last_supply_date'];

    protected $dates = ['last_supply_date'];

    public function meta()
    {
        return $this->hasMany(SupplierMeta::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
