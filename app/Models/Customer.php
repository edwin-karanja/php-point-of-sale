<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'telephone', 'email', 'picture'
    ];

    public $appends = ['balance'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function contacts()
    {
        return $this->hasMany(CustomerContact::class);
    }

    public function getBalanceAttribute()
    {
        return $this->sales()->withPartialOrZeroPayment()->sum('balance_due');
    }

    public function getPictureAttribute($value)
    {
        return !is_null($value) ? $this->picture : $this->getImagePlaceholder();
    }

    public function getImagePlaceholder()
    {
        return asset('storage/app-img/customer/placeholder.jpg');
    }
}
