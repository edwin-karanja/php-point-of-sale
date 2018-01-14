<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Item;

class Inventory extends Model
{
    public $timestamps = false;

    protected $dates = ['trans_date'];

    protected $fillable = [
        'item_id', 'user_id', 'trans_date', 'comments', 'trans_inventory'
    ];

    public $with = ['user'];

    public function setTransDateAttribute()
    {
        $this->attributes['trans_date'] = Carbon::now();
    }

    public function getTransDateAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }

    public function scopeLatestFirst($builder)
    {
        $builder->orderBy('trans_date', 'desc');
    }

    public function isPositiveAdjustment()
    {
        if ($this->trans_inventory > 0) {
            return true;
        }
    }

    public function isNegativeAdjustment()
    {
        if ($this->trans_inventory < 0) {
            return true;
        }
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
