<?php

namespace App\Helpers;

class Util
{

    public static function inBetween($value, $start, $end): bool
    {
        return  $start <= $value && $end >= $value;
    }

}
