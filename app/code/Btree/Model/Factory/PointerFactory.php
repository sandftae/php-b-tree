<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Factory;

use Play\Hard\Code\Btree\Api\BtreeNodeKeyInterface;
use Play\Hard\Frame\Factory\Entity\EntityFactory;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Play\Hard\Code\Btree\Api\PointerInterface;

/**
 * @final PointerFactory
 *
 * @package Play\Hard\Code\Btree\Model
 */
final readonly class PointerFactory
{
    /**
     * PointerFactory constructor
     *
     * @param EntityFactory $entityFactory
     */
    public function __construct(private EntityFactory $entityFactory) {}

    /**
     * Create a pointer model
     *
     * @param BtreeNodeInterface $node
     * @param BtreeNodeKeyInterface $currentKey
     * @param BtreeNodeKeyInterface|null $nextKey
     *
     * @return PointerInterface
     */
    public function create(
        BtreeNodeInterface     $node,
        BtreeNodeKeyInterface  $currentKey,
        ?BtreeNodeKeyInterface $nextKey
    ): PointerInterface {
        $arguments = ['node' => $node, 'currentKey' => $currentKey, 'nextKey' => $nextKey];
        return $this->entityFactory->create(PointerInterface::class, $arguments);
    }
}