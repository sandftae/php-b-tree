<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory\Resolver;

use Play\Hard\Frame\Factory\DynamicObjectFactoryInterface;

/**
 * @interface ConstructorCompositeResolverInterface
 *
 * @package Play\Hard\Frame\Factory\Resolver
 */
interface ConstructorCompositeResolverInterface
{
    /**
     * Resolve constructor params
     *
     * @param DynamicObjectFactoryInterface $dynamicObjectFactory
     * @param \ReflectionParameter $constructParam
     * @param array $diArgumentsListed
     *
     * @return array<string, int, object>
     */
    public function resolve(
        DynamicObjectFactoryInterface $dynamicObjectFactory,
        \ReflectionParameter $constructParam,
        array $diArgumentsListed
    ): array;
}