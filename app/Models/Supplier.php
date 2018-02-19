<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SupplierContact;
use App\Models\SupplierBanking;

class Supplier extends Model
{
    protected $fillable = ['name', 'description', 'total_supplied_amount', 'last_supply_date', 'vat_pin'];

    protected $dates = ['last_supply_date'];

    public function setVatPinAttribute($value)
    {
        $this->attributes['vat_pin'] = strtoupper($value);
    }

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function bankings()
    {
        return $this->hasMany(SupplierBanking::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
