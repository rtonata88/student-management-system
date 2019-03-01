<?php

namespace App\EloquentFilters\Profile;

use Fouladgar\EloquentBuilder\Support\Foundation\Contracts\IFilter as Filter;
use Illuminate\Database\Eloquent\Builder;

class TeamFilter implements Filter
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
        return $builder->where('team_id', '=', $value);
    }
}