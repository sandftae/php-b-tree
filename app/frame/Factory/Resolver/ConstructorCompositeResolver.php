<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory\Resolver;

use Play\Hard\Frame\Factory\DynamicObjectFactoryInterface;

/**
 * @final ConstructorCompositeResolver
 *
 * @package Play\Hard\Frame\Factory\Resolver
 */
final readonly class ConstructorCompositeResolver implements ConstructorCompositeResolverInterface
{
    /** @inheritDoc */
    public function resolve(
        DynamicObjectFactoryInterface $dynamicObjectFactory,
        \ReflectionParameter $constructParam,
        array $diArgumentsListed
    ): array {
        $resolvedParams = [];
        foreach ($this->getResolvers() as $resolver) {
            $resolvedParams = array_merge(
                $resolvedParams,
                $resolver->resolve($dynamicObjectFactory, $constructParam, $diArgumentsListed)
            );
        }

        return $resolvedParams;
    }

    /**
     * Get Resolvers
     *
     * @return array<ConstructorCompositeResolverInterface>
     */
    private function getResolvers(): array
    {
        return [
            new ClassVariableResolver,
            new ComplexVariableResolver,
            new DefaultVariableResolver
        ];
    }
}