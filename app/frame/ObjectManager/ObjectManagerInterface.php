<?php

declare(strict_types=1);

namespace Play\Hard\Frame\ObjectManager;

/**
 * @interface ObjectManagerInterface
 *
 * @package Play\Hard\Frame\ObjectManager
 */
interface ObjectManagerInterface
{
    /**
     * Return an object instance of the class name given
     *
     * @param string $objectType
     * @param array $arguments
     *
     * @return object
     */
    public function get(string $objectType, array $arguments): object;
}