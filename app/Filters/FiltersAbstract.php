<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class FiltersAbstract
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter(Builder $builder)
    {
        foreach($this->getFilters() as $filter => $class) {
            var_dump($this->resolveFilter($filter));
        }

        return $builder;
    }

    protected function getFilters()
    {
        return $this->filterFilters($this->filters);
    }

    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }

    protected function filterFilters($filters)
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }
}