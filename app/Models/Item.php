<?php

namespace App\Models;

use App\Models\Quantity;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Inventory;
use Illuminate\Support\Facades\Cache;

class Item extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $hidden = [
        'deleted_at', 'created_at'
    ];

    protected $fillable = [
        'name', 'description', 'selling_price', 'buying_price', 'reorder_level', 'category_id'
    ];

    protected $appends = [
        'updated_at_human', 'qtty', 'cat'
    ];

    public function getAppends()
    {
        return $this->appends;
    }

    public function scopeUpdatesFirst($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function getCatAttribute()
    {
        if ($this->category) {
            return $this->category->name;
        }

        return null;
    }

    public function getUpdatedAtHumanAttribute()
    {
        if ($this->updated_at) {
            return $this->updated_at->diffForHumans();
        }

        return $this->updated_at;
    }

    public function getQttyAttribute()
    {
        if ($this->quantity) {
            return $this->quantity->quantity;
        }

        return null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quantity()
    {
        return $this->hasOne(Quantity::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class)->orderBy('trans_date', 'desc');
    }

    public function cacheKey()
    {
        return sprintf(
            "%s/%s-%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }

    public function getCachedItems()
    {
        return Cache::remember($this->cacheKey() . ':items', 15, function () {
            return $this->with('category', 'quantity')->get();
        });
    }

    public static function getGroupedItems()
    {
        return static::updatesFirst()
            ->with(['category', 'quantity'])
            ->get()
            ->groupBy(function ($item) {
                return $item->category->name ?? 'Ungrouped';
            });
    }
}
