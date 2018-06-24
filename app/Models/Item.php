<?php

namespace App\Models;

use App\Models\Quantity;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Inventory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Auditable;
use \OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Item extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

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

    /**
     * Only store 20 audit events for this model
     * @var int
     */
    protected $auditThreshold = 10;

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.selling_price')) {
            $data['old_values']['buying_price'] = $this->getOriginal('buying_price');
            $data['new_values']['buying_price'] = $this->getAttribute('buying_price');
        }

        if (Arr::has($data, 'new_values.buying_price')) {
            $data['old_values']['selling_price'] = $this->getOriginal('selling_price');
            $data['new_values']['selling_price'] = $this->getAttribute('selling_price');
        }

        return $data;
    }

    public function getAppends()
    {
        return $this->appends;
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
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
