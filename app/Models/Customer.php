<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'gender', 'telephone', 'email'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
