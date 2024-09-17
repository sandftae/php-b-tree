<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Trait;

/**
 * @trait MinMax
 *
 * @package Play\Hard\Code\Btree\Model\Trait
 */
trait MinMax
{
    /**
     * Get the highest value of node keys
     *
     * @param array $data
     *
     * @return int
     */
    private function getMaxVal(array $data): int
    {
        return (int) max(array_keys($data));
    }

    /**
     * Get the smallest value of node keys
     *
     * @param array $data
     *
     * @return int
     */
    private function getMinVal(array $data): int
    {
        return (int) min(array_keys($data));
    }
}