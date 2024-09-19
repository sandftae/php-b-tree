<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory\Resolver;

use Play\Hard\Frame\Factory\DynamicObjectFactoryInterface;

/**
 * @final ClassVariableResolver
 *
 * @package Play\Hard\Frame\Factory\Resolver
 */
final readonly class ClassVariableResolver implements ConstructorCompositeResolverInterface
{
    /** @inheritDoc */
    public function resolve(
        DynamicObjectFactoryInterface $dynamicObjectFactory,
        \ReflectionParameter $constructParam,
        array $diArgumentsListed
    ): array {
        $class = $constructParam->getClass();
        if ($class) {
            if ($class->isInterface() && !$constructParam->isDefaultValueAvailable()) {
                return [$constructParam->getName() => $dynamicObjectFactory->create($class->getName())];
            }

            $constructParamVal = !$class->isInstantiable()
                ? $constructParam->getDefaultValue()
                : $dynamicObjectFactory->create($class->getName());

            return [$constructParam->getName() =>$constructParamVal];
        }

        return [];
    }
}