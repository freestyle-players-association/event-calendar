<?php

namespace App\Core;

use IntlDateFormatter;

class LocaleDateFormatter
{
    public static function format(string $locale, string $date): string
    {
        $formatter = new IntlDateFormatter(
            $locale,
            IntlDateFormatter::MEDIUM,
            IntlDateFormatter::NONE
        );
        return $formatter->format(strtotime($date));
    }

    public static function formatShort(string $locale, string $date): string
    {
        $formatter = new IntlDateFormatter(
            locale: $locale,
            dateType: IntlDateFormatter::NONE,
            timeType: IntlDateFormatter::NONE,
            pattern: 'd MMM',
        );
        return $formatter->format(strtotime($date));
    }
}
