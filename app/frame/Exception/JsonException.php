<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Exception;

/**
 * @final JsonException
 *
 * @package Play\Hard\Frame\Exception
 */
final class JsonException extends \JsonException
{
    /**
     * Create more understandable JSON error
     *
     * @return JsonException
     */
    public static function createFromError(): JsonException
    {
        return new static(\json_last_error_msg(), \json_last_error());
    }
}