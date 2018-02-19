<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 'supplier_id', 'ref_no', 'purchase_total', 'transaction_date'
    ];

    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
