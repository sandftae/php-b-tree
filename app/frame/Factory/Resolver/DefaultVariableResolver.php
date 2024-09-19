<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory\Resolver;

use Play\Hard\Frame\Factory\DynamicObjectFactoryInterface;

/**
 * @final DefaultVariableResolver
 *
 * @package Play\Hard\Frame\Factory\Resolver
 */
final readonly class DefaultVariableResolver implements ConstructorCompositeResolverInterface
{
    /** @inheritDoc */
    public function resolve(
        DynamicObjectFactoryInterface $dynamicObjectFactory,
        \ReflectionParameter $constructParam,
        array $diArgumentsListed
    ): array {
        $rows = [];
        $class = $constructParam->getClass();
        $constructParamName = $constructParam->getName();

        if (!$class && empty($diArgumentsListed)) {
            $rows[$constructParamName] = $constructParam->getDefaultValue();
        }

        return $rows;
    }
}