<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Exception;

/**
 * @final FilesystemException
 *
 * @package Play\Hard\Frame\Exception
 */
final class FilesystemException extends \ErrorException
{
    /**
     * Create more understandable error
     *
     * @return FilesystemException
     */
    public static function createFromPhpError(): FilesystemException
    {
        $error = error_get_last();

        return new static($error['message'] ?? 'An error occurred', 0, $error['type'] ?? 1);
    }
}