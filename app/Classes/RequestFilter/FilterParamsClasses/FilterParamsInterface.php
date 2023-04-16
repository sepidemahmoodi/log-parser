<?php
namespace App\Classes\RequestFilter\FilterParamsClasses;

use Illuminate\Database\Query\Builder;

interface FilterParamsInterface
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function filter(Builder $builder, string $value):Builder;
}
