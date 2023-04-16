<?php
namespace App\Classes\RequestFilter\FilterClasses;

use App\Classes\RequestFilter\AbstractFilter;
use App\Classes\RequestFilter\FilterParamsClasses\EndDate;
use App\Classes\RequestFilter\FilterParamsClasses\ServiceName;
use App\Classes\RequestFilter\FilterParamsClasses\StartDate;
use App\Classes\RequestFilter\FilterParamsClasses\StatusCode;

class LogFilter extends AbstractFilter
{
    /**
     * @var array<mixed>
     */
    protected $filters = [
        'service_name' => ServiceName::class,
        'status_code' => StatusCode::class,
        'start_date' => StartDate::class,
        'end_date' => EndDate::class
    ];
}
