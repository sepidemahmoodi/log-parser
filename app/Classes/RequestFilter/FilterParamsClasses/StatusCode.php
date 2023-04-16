<?php
namespace App\Classes\RequestFilter\FilterParamsClasses;

use Illuminate\Database\Query\Builder;

class StatusCode implements FilterParamsInterface
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function filter(Builder $builder, string $value): Builder
    {
        return $builder->where('http_status_code', $value);
    }
}

