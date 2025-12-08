<?php

namespace App\Enums;

/**
 * @method static cases()
 */
trait ValueOf
{

    /**
     * @throws \Exception
     */
    public static function valueOf(string $target): self
    {
        foreach (self::cases() as $case) {
            if ($case->value == $target || $case->name == $target) {
                return $case;
            }
        }

        throw new \Exception('Case not found!');
    }
}
