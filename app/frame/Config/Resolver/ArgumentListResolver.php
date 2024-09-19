<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config\Resolver;

use Play\Hard\Frame\Config\Enum\EnumDiArgTypes;

/**
 * @final ArgumentListResolver
 *
 * @package Play\Hard\Frame\Config\Resolver
 */
final class ArgumentListResolver implements CompositeResolverInterface
{
    /** @const string */
    public const ARG_LIST_NODE_NAME = 'argumentList';

    /** @inheritDoc */
    public function resolve(array $content): array
    {
        $bindings = [];
        if (isset($content[self::ARG_LIST_NODE_NAME])) {
            foreach ($content[self::ARG_LIST_NODE_NAME] as $scalar) {
                $forType = $scalar['@attributes']['for'] ?? null;
                $argumentList = [];

                if (isset($scalar['arguments']['argument'])) {
                    $argumentList = $scalar['arguments']['argument'];
                    if (isset($argumentList['@attributes'])) {
                        $argumentList = [$argumentList];
                    }
                }

                foreach ($argumentList as $argument) {
                    ['name' => $argumentName, 'type' => $argumentType] = $argument['@attributes'];
                    $variableValue = $argument['@content'] ?? null;

                    if($argumentType === EnumDiArgTypes::ARRAY->getCode()) {
                        $variableValue = $this->walkComplexNode($argument);
                    }

                    if ($variableValue) {
                        $bindings[$forType][$argumentName] = [$argumentType => $variableValue];
                    }
                }
            }

            return [self::ARG_LIST_NODE_NAME => $bindings];
        }

        # otherwise, just an empty array<null>
        return $bindings;
    }

    /**
     * Walk through a complex node and try to build argument type tree
     *
     * @param array<string> $argumentItems
     *
     * @return array<string>
     */
    private function walkComplexNode(array $argumentItems): array
    {
        $rows = [];
        foreach ($argumentItems['item'] ?? [] as $item) {
            $itemVal = $item['@content'] ?? null;
            if ($itemVal) {
                ['name' => $itemName] = $item['@attributes'];
                $rows = array_merge_recursive($rows, [$itemName => $itemVal]);
            }
        }

        return $rows;
    }
}