<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config\Enum;

/**
 * @enum EnumDiArgTypes
 *
 * @package Play\Hard\Frame\Config\Enum
 */
enum EnumDiArgTypes
{
    /** @case object */
    case OBJECT;

    /** @case array */
    case ARRAY;

    /** @case scalar<int, string> */
    case SCALAR;

    /**
     * Get current ENUM code
     *
     * @return string
     */
    public function getCode(): string
    {
        return match ($this) {
            self::ARRAY  => 'array',
            self::SCALAR => 'scalar',
            self::OBJECT => 'object'
        };
    }

    /**
     * Get all scalar types allowed to use type casting on it
     *
     * @return array<string>
     */
    public static function getAllScalarCode(): array
    {
        return ['int', 'integer', 'float', 'string', 'bool', 'boolean'];
    }
}
