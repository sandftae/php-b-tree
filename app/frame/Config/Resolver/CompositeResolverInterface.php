<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config\Resolver;

/**
 * @interface CompositeResolverInterface
 *
 * @package Play\Hard\Frame\Config\Resolver
 */
interface CompositeResolverInterface
{
    /**
     * This composite simply reads the xml dump of the configuration and builds/fetches an array with the required structure on it
     *
     * @param array $content
     *
     * @return array<string>
     */
    public function resolve(array $content): array;
}