<?php

declare(strict_types=1);

namespace Ejem\Enum;

trait EnumTrait
{
    /**
     * Get possible values (enum constants' values, not constant names!) of this enum
     *
     * @return string[]
     */
    public static function getPossibleValues(): array
    {
        $refl = new \ReflectionClass(get_called_class());
        return array_values($refl->getConstants());
    }

    /**
     * Check if the $value is a value of any constant of current class.
     */
    public static function isValidValue($value): bool
    {
        return in_array($value, static::getPossibleValues(), TRUE);
    }

    /**
     * Throws exception if a value not valid for this enum is passed.
     *
     * Useful for assertions in constructors and setters using
     * current enum class as a value.
     *
     * @throws InvalidEnumValueException
     * @return void
     */
    public static function assertValidValue($value)
    {
        if (!static::isValidValue($value)) {
            throw new InvalidEnumValueException(sprintf(
                '""%s" is not a valid value for enum %s',
                $value,
                __CLASS__
            ));
        }
    }
}
