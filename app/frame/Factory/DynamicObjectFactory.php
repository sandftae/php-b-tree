<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Factory;

use Play\Hard\Frame\Factory\Resolver\ConstructorCompositeResolver;
use Play\Hard\Frame\Config\DiConfigProvider as ConfigReader;

/**
 * @final class DynamicObjectFactory
 *
 * @package Play\Hard\Frame\Factory
 */
final readonly class DynamicObjectFactory implements DynamicObjectFactoryInterface
{
    /**
     * DynamicObjectFactory constructor.
     *
     * @param ConstructorCompositeResolver $constrCompositeResolver
     * @param ConfigReader $configReader
     */
    public function __construct(
        private ConstructorCompositeResolver $constrCompositeResolver,
        private ConfigReader $configReader
    ) {}

    /** @inheritDoc */
    public function create(string $type, array $parameters = []): object
    {
        return $this->resolve($this->configReader->getInstantiation($type) ?: $type, $parameters);
    }

    /**
     * Resolve object dependencies trees
     *
     * @param string $type
     * @param array<string, mixed> $parameters
     *
     * @return object
     *
     * @throws \ReflectionException
     */
    private function resolve(string $type, array $parameters): object
    {
        $reflector = new \ReflectionClass($type);
        if (!$reflector->isInstantiable()) {
            throw new \Exception(sprintf('Class [%s] is not instantiable', $type));
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $constParams = $constructor->getParameters();

        if(!empty($parameters)) {
            $filteredConstructorParams = [];
            if($constParams) {
                $fn = fn(\ReflectionParameter $refParam) => !array_key_exists($refParam->getName() ?: null, $parameters);
                $filteredConstructorParams = array_filter($constParams, $fn);
                $filteredConstructorParams = $this->getDependencies($filteredConstructorParams);
            }

            return $reflector->newInstance(...$parameters, ...$filteredConstructorParams);
        }

        return $reflector->newInstanceArgs($this->getDependencies($constParams));
    }

    /**
     * Get object parameter dependencies
     *
     * @param array<\ReflectionParameter, string, mixed> $constructParams
     *
     * @return array<string, object, null, int>
     *
     * @throws \Exception
     */
    private function getDependencies(array $constructParams): array
    {
        $dependencies = [];

        foreach ($constructParams as $constructParam) {
            $diArgsDeclared = [];
            $class = $constructParam->getClass();
            $constructParamName = $constructParam->getName();

            # means that this parameter [$constructParam] is not an object param;
            # try to load this parameter from the di.xml file if it was embedded in it
            if (!$class) {
                $declaringClassName = $constructParam->getDeclaringClass()->getName();
                $diArgsDeclared = $this->configReader->getArgumentList($declaringClassName, $constructParamName);
            }

            $dependencies = array_merge_recursive(
                $dependencies,
                $this->constrCompositeResolver->resolve($this, $constructParam, $diArgsDeclared)
            );
        }

        return $dependencies;
    }
}