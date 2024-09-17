<?php
declare(strict_types=1);

namespace Play\Hard\Frame\Factory\Entity;

use Play\Hard\Frame\ObjectManagerInvoker;

/**
 * @final EntityFactory
 *
 * @package Play\Hard\Code\Btree\Model\Factory
 */
final readonly class EntityFactory
{
    /**
     * Create an entity by name with arguments given
     *
     * @param string $entityType
     * @param array $arguments
     *
     * @return object
     */
    public function create(string $entityType, array $arguments): object
    {
        $objectContainer = ObjectManagerInvoker::getInstance();
        return $objectContainer->get($entityType, $arguments);
    }
}