<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\TreeElement;

use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};

/**
 * @final BTreeNodeKey
 *
 * @@package Play\Hard\Code\Btree\Model\TreeElement
 */
final class BTreeNodeKey implements BtreeNodeKeyInterface
{
    /**
     * BTreeNodeKey constructor.
     *
     * @param int $keyValue
     * @param BtreeNodeInterface|null $leftNode
     * @param BtreeNodeInterface|null $rightNode
     */
    public function __construct(
        private readonly int $keyValue,
        private ?BtreeNodeInterface $leftNode = null,
        private ?BtreeNodeInterface $rightNode = null
    ) {}

    /** @inheritDoc */
    public function getValue(): int
    {
        return $this->keyValue;
    }

    /** @inheritDoc */
    public function getLeftNode(): ?BtreeNodeInterface
    {
        return $this->leftNode;
    }

    /** @inheritDoc */
    public function setLeftNode(BtreeNodeInterface $node): BtreeNodeKeyInterface
    {
        $this->leftNode = $node;

        return $this;
    }

    /** @inheritDoc */
    public function getRightNode(): ?BtreeNodeInterface
    {
        return $this->rightNode;
    }

    /** @inheritDoc */
    public function setRightNode(BtreeNodeInterface $node): BtreeNodeKeyInterface
    {
        $this->rightNode = $node;

        return $this;
    }
}