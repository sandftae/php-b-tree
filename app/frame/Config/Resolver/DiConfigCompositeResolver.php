<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config\Resolver;

/**
 * @final DiConfigCompositeResolver
 *
 * @package Play\Hard\Frame\Config\Resolver
 */
final class DiConfigCompositeResolver implements CompositeResolverInterface
{
    /** @inheritDoc */
    public function resolve(array $content): array
    {
        $rows = [];
        foreach ($this->getLoaderList() as $loader) {
            $rows = array_merge_recursive($rows, $loader->resolve($content));
        }

        return $rows;
    }

    /**
     * Get composite tree`s leafs
     *
     * @return array<CompositeResolverInterface>
     */
    private function getLoaderList(): array
    {
        return [new ArgumentListResolver, new ImplementResolver];
    }
}