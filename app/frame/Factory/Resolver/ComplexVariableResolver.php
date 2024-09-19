<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory\Resolver;

use Play\Hard\Frame\Factory\DynamicObjectFactoryInterface;
use Play\Hard\Frame\Config\Enum\EnumDiArgTypes;

/**
 * @final ComplexVariableResolver
 *
 * @package Play\Hard\Frame\Factory\Resolver
 */
final readonly class ComplexVariableResolver implements ConstructorCompositeResolverInterface
{
    /** @inheritDoc */
    public function resolve(
        DynamicObjectFactoryInterface $dynamicObjectFactory,
        \ReflectionParameter $constructParam,
        array $diArgumentsListed
    ): array {
        $rows = [];
        $class = $constructParam->getClass();

        if (!$class && !empty($diArgumentsListed)) {
            foreach ($diArgumentsListed as $diArgType => $diArgListed) {
                $depVal = $this->getDependencyValue($dynamicObjectFactory, $constructParam, $diArgType, $diArgListed);
                $rows = array_merge_recursive($rows, $depVal);
            }
        }

        return $rows;
    }

    /**
     * Get dependency value
     *
     * @param DynamicObjectFactoryInterface $dynamicObjectFactory
     * @param \ReflectionParameter $constructParam
     * @param string $diArgType
     * @param string|array $diArgListed
     *
     * @return string|array<string, int, object>
     */
    public function getDependencyValue(
        DynamicObjectFactoryInterface $dynamicObjectFactory,
        \ReflectionParameter $constructParam,
        string $diArgType,
        string|array $diArgListed
    ) : string|array {
        $typeToCast = null;
        $scalarType = EnumDiArgTypes::SCALAR->getCode();
        $objectType = EnumDiArgTypes::OBJECT->getCode();
        $arrayType  = EnumDiArgTypes::ARRAY->getCode();
        $constParamName = $constructParam->getName();

        $fnType = function (string $typeToCast, mixed $variable) {
            settype($variable, $typeToCast);
            return $variable;
        };

        $fn = function (array $itemsToWalkThrough) use ($dynamicObjectFactory){
            $rows = [];
            foreach ($itemsToWalkThrough as $itemName => $itemValue) {
                # is the value instantiable? otherwise this is a scalar type like int, string, etc
                $itemValue = (class_exists($itemValue) || interface_exists($itemValue))
                    ? $dynamicObjectFactory->create($itemValue)
                    : $itemValue;
                $rows[$itemName] = $itemValue;
            }

            return $rows;
        };

        if($constructParam->hasType()) {
            $paramType = $constructParam->getType()->getName();
            if(in_array($paramType, EnumDiArgTypes::getAllScalarCode())) {
                $typeToCast = $paramType;
            }
        }

        return match (true) {
            $diArgType === $scalarType => [$constParamName => $typeToCast ? $fnType($typeToCast, $diArgListed) : $diArgListed],
            $diArgType === $objectType => [$constParamName => $dynamicObjectFactory->create($diArgListed)],
            $diArgType === $arrayType  => [$constParamName => $fn($diArgListed)],
        };
    }
}