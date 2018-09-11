<?php
/**
 * Created by PhpStorm.
 * User: pixeledge
 * Date: 08/08/2018
 * Time: 22:46
 */

namespace App\Filters\Items;


use Illuminate\Database\Eloquent\Builder;

class TrashFilter
{
    public function handle(Builder $builder, $value)
    {
        if ($value == 'true') {
            return $builder->onlyTrashed();
        }

        return $builder;
    }
}