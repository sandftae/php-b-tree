<?php

namespace filesystem;

use Play\Hard\Frame\Exception\FilesystemException;

/**
 * Safe calls of the php file_get_contents function
 *
 * @param string $filename
 * @param bool $use_include_path
 * @param mixed $context
 * @param int $offset
 * @param int|null $length
 *
 * @return string
 *
 * @throws FilesystemException
 */
function file_get_contents(
    string $filename,
    bool   $use_include_path = false,
    mixed  $context = null,
    int    $offset = 0,
    int    $length = null
): string {
    error_clear_last();

    $safeCallResults = match (true) {
        $context !== null => \file_get_contents($filename, $use_include_path, $context),
        $length !== null => \file_get_contents($filename, $use_include_path, $context, $offset, $length),
        $offset !== 0 => \file_get_contents($filename, $use_include_path, $context, $offset),
        default => \file_get_contents($filename, $use_include_path)
    };

    if (!$safeCallResults) {
        throw FilesystemException::createFromPhpError();
    }

    return $safeCallResults;
}


/**
 * Safe calls of the php file_put_contents function
 *
 * @param string $filename
 * @param mixed $data
 * @param int $flags
 * @param mixed $context
 *
 * @return int
 *
 * @throws FilesystemException
 */
function file_put_contents(
    string $filename,
    mixed $data,
    int $flags = 0,
    mixed $context = null
): int {
    error_clear_last();

    $safeCallResults = match (true) {
        $context !== null => \file_put_contents($filename, $data, $flags, $context),
        default => \file_put_contents($filename, $data, $flags)
    };

    if (!$safeCallResults) {
        throw FilesystemException::createFromPhpError();
    }
    return $safeCallResults;
}
