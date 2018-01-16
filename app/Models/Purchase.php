<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 'supplier_id', 'ref_no', 'purchase_total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
