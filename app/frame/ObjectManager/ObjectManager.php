<?php

declare(strict_types=1);

namespace Play\Hard\Frame\ObjectManager;

use Play\Hard\Frame\Factory\DynamicObjectFactory;

/**
 * @final ObjectManager
 *
 * @package Play\Hard\Frame\ObjectManager
 */
final readonly class ObjectManager implements ObjectManagerInterface
{
    /**
     * ObjectManager constructor.
     *
     * @param DynamicObjectFactory $factory
     */
    public function __construct(private DynamicObjectFactory $factory) {}

    /** @inheritDoc */
    public function get(string $objectType, array $arguments = []): object
    {
         return $this->factory->create($objectType, $arguments);
    }
}