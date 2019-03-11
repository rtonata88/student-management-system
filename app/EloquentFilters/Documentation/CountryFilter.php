<?php

namespace App\EloquentFilters\Documentation;

use Fouladgar\EloquentBuilder\Support\Foundation\Contracts\IFilter as Filter;
use Illuminate\Database\Eloquent\Builder;

class CountryFilter implements Filter
{
    /**
     * Apply the Fullname condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('profiles.country_id', '=', $value);
    }
}