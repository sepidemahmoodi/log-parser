<?php
namespace App\Classes\DateFormatter;

interface DateConverterInterface
{
    public function convert($date, $format);
}
