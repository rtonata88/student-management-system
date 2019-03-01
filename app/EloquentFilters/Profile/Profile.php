<?php

namespace App\EloquentFilters\Profile;

use Fouladgar\EloquentBuilder\Support\Foundation\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;

class FullnameFilter implements Filter
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
        return $builder->where('fullname', '=', $value);
    }
}


class SurnameEqualsToFilter implements Filter
{
    /**
     * Apply the Surname condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('lastname', '=', $value);
    }
}

class OrganizationIdEqualsToFilter implements Filter
{
    /**
     * Apply the Organization condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('organization_id', '=', $value);
    }
}

class PositionEqualsToFilter implements Filter
{
    /**
     * Apply the Position condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('position', '=', $value);
    }
}

class CityIdEqualsToFilter implements Filter
{
    /**
     * Apply the City condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('city_id', '=', $value);
    }
}

class CountryIdEqualsToFilter implements Filter
{
    /**
     * Apply the Country condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('country_id', '=', $value);
    }
}

class SectorIdEqualsToFilter implements Filter
{
    /**
     * Apply the Sector condition to the query.
     *
     * @param Builder $builder
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('sector_id', '=', $value);
    }
}

class TeamIdEqualsToFilter implements Filter
{
    /**
     * Apply the Team condition to the query.
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