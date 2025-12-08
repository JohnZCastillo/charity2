<?php

namespace App\Helpers;

use NumberFormatter;

class CurrencyFormatter
{

    public static function currency($amount): string
    {
        $locale = 'en_PH';

        // Create a NumberFormatter instance for currency formatting
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        // Format the amount as currency
        return $formatter->formatCurrency($amount, 'PHP');

    }

    public static function format($amount): string
    {
        return number_format($amount, 2);
    }

    public static function percent($value, $totalValue): int
    {
        $percent = ($value / $totalValue) * 100;

        return min($percent, 100);
    }

}
