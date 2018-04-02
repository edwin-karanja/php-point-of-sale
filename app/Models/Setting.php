<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Setting extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'name', 'short_name', 'picture', 'location',
        'address', 'timezone', 'tax_percent', 'receipt_contents'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->width(50)
            ->height(50);

        $this
            ->addMediaConversion('thumbnail')
            ->width(250)
            ->height(260);
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('store-image')
            ->singleFile();
    }
}
