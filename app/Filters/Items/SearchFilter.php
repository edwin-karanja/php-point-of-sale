<?php
/**
 * Created by PhpStorm.
 * User: pixeledge
 * Date: 02/08/2018
 * Time: 18:10
 */

namespace App\Filters\Items;


use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    public function handle(Builder $builder, $value)
    {
        if ($value) {
            $builder->whereHas('category', function($query) use ($value) {
                $query->where('name', 'like', '%'.$value.'%');
            })->orWhere('name', 'like', '%'.$value.'%')
                ->orWhere('description', 'like', '%'.$value.'%')
                ->orWhere('selling_price', 'like', '%'.$value.'%')
                ->orWhere('buying_price', 'like', '%'.$value.'%');
        }

        return $builder;
    }
}