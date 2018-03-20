<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name', 'short_name', 'picture', 'location', 'address', 'timezone', 'tax_percent', 'receipt_contents'
    ];
}
