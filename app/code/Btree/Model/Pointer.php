<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model;

use Play\Hard\Code\Btree\Model\Trait\MinMax;
use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface,
    PointerInterface
};

/**
 * @final Pointer
 *
 * @package Play\Hard\Code\Btree\Model
 */
final readonly class Pointer implements PointerInterface
{
    use MinMax;

    /**
     * Pointer constructor.
     *
     * @param BtreeNodeInterface $node
     * @param BtreeNodeKeyInterface $currentKey
     * @param BtreeNodeKeyInterface|null $nextKey
     */
    public function __construct(
        private BtreeNodeInterface $node,
        private BtreeNodeKeyInterface $currentKey,
        private ?BtreeNodeKeyInterface $nextKey
    ) {}

    /** @inheritDoc */
    public function getDirection(): bool
    {
        # left hand direction or right hand direction
        $keys = $this->getNode()->getKeys();
        return $this->getMaxVal($keys) - $this->getCurrentKey()->getValue() > 0
            && $this->getMinVal($keys) - $this->getCurrentKey()->getValue() > 0;
    }

    /** @inheritDoc */
    public function isInBetweenPosition(): bool
    {
        if (!$this->getNextKey()) {
            return false;
        }

        # "in-between", means position of "x": a < x < b
        $keys = $this->getNode()->getKeys();
        return $this->getDirection()
            && $this->getCurrentKey()->getValue() < $this->getMinVal($keys)
            && $this->getMaxVal($keys) < $this->getNextKey()->getValue();
    }

    /** @inheritDoc */
    public function getCurrentKey(): BtreeNodeKeyInterface
    {
        return $this->currentKey;
    }

    /** @inheritDoc */
    public function getNextKey(): ?BtreeNodeKeyInterface
    {
        return $this->nextKey;
    }

    /** @inheritDoc */
    public function getNode(): BtreeNodeInterface
    {
        return $this->node;
    }
}