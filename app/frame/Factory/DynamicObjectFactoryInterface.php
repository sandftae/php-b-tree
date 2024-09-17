<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory;

/**
 * @interface DynamicObjectFactoryInterface
 *
 * @package Play\Hard\Frame\Factory
 */
interface DynamicObjectFactoryInterface
{
    /**
     * Create an object based on objectId given
     *
     * @param string $type
     * @param array $parameters
     *
     * @return object
     */
    public function create(string $type, array $parameters = []): object;
}