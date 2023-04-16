<?php
namespace App\Classes\RequestFilter;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    protected Request $request;

    /**
     * @var array<mixed>
     */
    protected $filters = [];

    /**
     * AbstractFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        foreach($this->getFilters() as $filter => $value)
        {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
        return $builder;
    }

    /**
     * @return array<mixed>
     */
    protected function getFilters():array
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }

    /**
     * @param string $filter
     * @return Object
     */
    protected function resolveFilter(string $filter): Object
    {
        return new $this->filters[$filter];
    }
}
