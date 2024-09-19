<?php

namespace iter;

/**
 * Just a function to iterate over an iterable in a manner similar to array_map and return an array
 * that is a  result of applying the callback function
 *
 * @param callable $function
 * @param iterable $iterable
 * @param bool $unpack
 * @param bool $keep_keys
 *
 * @return array
 */
function iterator_map(callable $function, iterable $iterable, bool $unpack = false, bool $keep_keys = false): array
{
    $mappedResult = [];

    foreach ($iterable as $key => $value) {
        if ($unpack) {
            $callbackResult = $function($value, $key);
            if (!is_array($callbackResult)) {
                $callbackResult = [$callbackResult];
            }
            if ($keep_keys) {
                $mappedResult = $mappedResult + $callbackResult;
            } else {
                $mappedResult = [...$mappedResult, ...$callbackResult];
            }
        } else {
            $mappedResult[] = $function($value, $key);
        }
    }

    return $mappedResult;
}

/**
 * Init ArrayIterator on a given array
 *
 * @param array $arrayToIterator
 *
 * @return \ArrayIterator
 */
function iterable_array(array $arrayToIterator): \ArrayIterator
{
    return new \ArrayIterator($arrayToIterator);
}