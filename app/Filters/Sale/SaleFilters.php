<?php

namespace App\Filters\Sale;

use App\Filters\FiltersAbstract;
use App\Models\Category;

class SaleFilters extends FiltersAbstract
{
    protected $filters = [
        'access' => Category::class
    ];
}