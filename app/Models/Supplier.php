<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'description', 'total_supplied_amount', 'last_supply_date'];

    protected $dates = ['last_supply_date'];


}
