<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SupplierContact;
use App\Models\SupplierBanking;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    protected $fillable = ['name', 'description', 'contact_info', 'vat_pin'];

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

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
