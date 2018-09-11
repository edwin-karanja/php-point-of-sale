<?php

namespace App\Filters\Items;

use Illuminate\Database\Eloquent\Builder;


class VisibleFilter
{
    public function handle(Builder $builder, $value)
    {
        $value = ($value == 'true' ? 1 : 0);

        return $builder->where('show_on_listing', $value);
    }
}