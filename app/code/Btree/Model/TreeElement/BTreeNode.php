<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\TreeElement;

use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};
use Uuid\Uuid;

/**
 * @final BTreeNode
 *
 * @package Play\Hard\Code\Btree\Model\TreeElement
 */
final class BTreeNode implements BtreeNodeInterface
{
    /**
     * BTreeNode constructor.
     *
     * @param array $childNodes
     * @param array $nodeKeys
     * @param int $capacity
     * @param string $uuid
     * @param bool|null $isRoot
     * @param BtreeNodeInterface|null $parentNode
     */
    public function __construct(
        private array                  $childNodes,
        private array                  $nodeKeys,
        private readonly int           $capacity,
        private readonly string        $uuid,
        private readonly ?bool         $isRoot = false,
        private ?BtreeNodeInterface    $parentNode = null
    ) {}

    /** @inheritDoc */
    public function addKey(BtreeNodeKeyInterface $nodeKey): BtreeNodeInterface
    {
        $this->nodeKeys[$nodeKey->getValue()] = $nodeKey;

        ksort($this->nodeKeys, SORT_NUMERIC);

        return $this;
    }

    /** @inheritDoc */
    public function setKeys(array $keys): BtreeNodeInterface
    {
        $this->nodeKeys = $keys;

        ksort($this->nodeKeys, SORT_NUMERIC);

        return $this;
    }

    /** @inheritDoc */
    public function getKeys(): array
    {
        return $this->nodeKeys;
    }

    /** @inheritDoc */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /** @inheritDoc */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /** @inheritDoc */
    public function getChildNodes(): array
    {
        return $this->childNodes;
    }

    /** @inheritDoc */
    public function setChildNodes(array $childNodes): BtreeNodeInterface
    {
        $this->childNodes = $childNodes;
        return $this;
    }

    /** @inheritDoc */
    public function removeNode(string $uuid): BtreeNodeInterface
    {
        if (isset($this->childNodes[$uuid])) {
            unset($this->childNodes[$uuid]);
        }

        return $this;
    }

    /** @inheritDoc */
    public function getPureNode(): BtreeNodeInterface
    {
        return (new self([], [], $this->getCapacity(), Uuid::generate(), false, $this));
    }

    /** @inheritDoc */
    public function setParentNode(?BtreeNodeInterface $node): BtreeNodeInterface
    {
        $this->parentNode = $node;

        return $this;
    }

    /** @inheritDoc */
    public function getParentNode(): ?BtreeNodeInterface
    {
        return $this->parentNode;
    }

    /** @inheritDoc */
    public function isRoot(): bool
    {
        return $this->isRoot;
    }

    /** @inheritDoc */
    public function isOverflow(): bool
    {
        return count($this->getKeys()) > $this->getCapacity() - 1;
    }
}