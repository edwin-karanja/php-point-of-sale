<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Sale\SaleFilters;

class Sale extends Model
{
    protected $fillable = [
        'user_id', 'customer_id', 'invoice_number', 'delivery_number', 'sale_status', 'payment_mode', 'comments', 'sale_total', 'sale_type', 'mpesa_ref_no'
    ];

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = auth()->user()->id;
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new SaleFilters($request))->filter($builder);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
