<?php

namespace func;

use Play\Hard\Frame\Exception\JsonException;

/**
 * Find the median of a given array and return the median value of the given array.
 * Depending on the array, the median can be either the $median or the $median - 1.
 *
 * @param array $array
 *
 * @return mixed
 */
function find_median(array $array): mixed
{
    $array = array_values($array);
    $totalKeys = count($array);
    $median = (int)round($totalKeys / 2);

    return (count($array) % 2) ? $array[$median - 1] : $array[$median];
}

/**
 * Returns a string containing the JSON representation of the supplied value
 *
 * @param mixed $value
 * @param int $flags
 * @param int $depth
 *
 * @return string
 *
 * @throws JsonException
 */
function json_encode(mixed$value, int $flags = 0, int $depth = 512): string
{
    error_clear_last();

    $safeResult = \json_encode($value, $flags, $depth);
    if ($safeResult === false) {
        throw JsonException::createFromError();
    }

    return $safeResult;
}