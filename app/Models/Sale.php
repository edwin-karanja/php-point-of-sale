<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use App\Models\SaleItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Sale\SaleFilters;
use App\Models\Payments;
use Carbon\Carbon;

class Sale extends Model
{
    const ZERO_PAYMENT = 'ZERO PAYMENT';
    const PARTIAL_PAYMENT = 'PARTIALLY PAID';
    const FULL_PAYMENT = 'FULLY PAID';


    protected $fillable = [
        'user_id', 'customer_id', 'invoice_number', 'delivery_number', 'sale_status', 'payment_mode', 'comments', 'sale_total', 'sale_type', 'mpesa_ref_no', 'payment_status', 'balance_due', 'amount_paid'
    ];

    public function scopeWithPayment($builder)
    {
        return $builder->where('payment_status', '!=', self::ZERO_PAYMENT);
    }

    public function scopeWithPartialOrZeroPayment($builder)
    {
        return $builder->where('payment_status',  self::PARTIAL_PAYMENT)
                    ->orWhere('payment_status',  self::ZERO_PAYMENT);
    }

    public function scopeRecent($builder)
    {
        return $builder->orderBy('updated_at', 'desc');
    }

    public function scopeMonth($query)
    {
        return $query->whereMonth(
            'created_at', '>=', Carbon::now()->month
        );
    }

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

    public function items()
    {
        return $this->hasMany(SaleItems::class);
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    public function concludeSale($saleTotal)
    {
        $data = [];
        $data['sale_total'] = $saleTotal;

        if ($this->payment_mode == 'oncredit') {
            $data['balance_due'] = $saleTotal - $this->amount_paid;
        } else {
            $data['amount_paid'] = $saleTotal;
            $data['balance_due'] = null;
        }

        $this->update($data);
        $this->updatePaymentStatus();
    }

    public function updatePaymentStatus()
    {
        if ($this->amount_paid >= $this->sale_total) {
            $this->update(['payment_status' => self::FULL_PAYMENT]);
        } elseif($this->amount_paid < $this->sale_total && $this->amount_paid > 0) {
            $this->update(['payment_status' => self::PARTIAL_PAYMENT]);
        } else {
            $this->update(['payment_status' => self::ZERO_PAYMENT]);
        }
    }

    public function isOnCredit()
    {
        return $this->payment_mode === 'oncredit';
    }
}
