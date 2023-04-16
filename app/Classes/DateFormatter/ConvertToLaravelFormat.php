<?php
namespace App\Classes\DateFormatter;

use Carbon\Carbon;

class ConvertToLaravelFormat implements DateConverterInterface
{
    public function convert($dateString, $format)
    {
        $carbonDate = Carbon::createFromFormat($format, $dateString);
        return $carbonDate->format('Y-m-d H:i:s');
    }
}
