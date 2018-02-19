<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    protected $fillable = [
        'customer_id',
        'contact_name',
        'contact_phone',
        'contact_email',
    ];

    public function supplier()
    {
        return $this->belongsTo(Customer::class);
    }
}
