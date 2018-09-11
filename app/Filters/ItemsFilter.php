<?php

namespace App\Filters;

use App\Filters\FiltersAbstract;
use App\Filters\Items\SearchFilter;
use App\Filters\Items\TrashFilter;
use App\Models\Item;
use App\Filters\Items\VisibleFilter;

class ItemsFilter extends FiltersAbstract
{
    protected $filters = [
        'listed' => VisibleFilter::class,
        'search' => SearchFilter::class,
        'deleted' => TrashFilter::class
    ];
}