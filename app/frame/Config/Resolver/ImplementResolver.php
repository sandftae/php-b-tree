<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config\Resolver;

/**
 * @final ImplementResolver
 *
 * @package Play\Hard\Frame\Config\Resolver
 */
final class ImplementResolver implements CompositeResolverInterface
{
    /** @const string */
    public const IMPLEMENTATION_ARG_NODE_NAME = 'implementation';

    /** @inheritDoc */
    public function resolve(array $content): array
    {
        $bindings = [];
        if (isset($content[self::IMPLEMENTATION_ARG_NODE_NAME])) {
            foreach ($content[self::IMPLEMENTATION_ARG_NODE_NAME] ?: [] as $instantiation) {
                $bindings = array_merge_recursive(
                    $bindings,
                    array_map(
                        function ($attribute) {
                            ['interface' => $interface, 'implementer' => $instance] = $attribute;

                            return [$interface => $instance];
                        },
                        $instantiation
                    )
                );
            }

            return [self::IMPLEMENTATION_ARG_NODE_NAME => reset($bindings)];
        }

        # otherwise, just an empty array<null>
        return $bindings;
    }
}