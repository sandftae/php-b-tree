<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Iterator;

use Play\Hard\Code\Btree\Model\Trait\MinMax;
use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};

/**
 * @final FilterByDirectionIterator
 *
 * @package Play\Hard\Code\Btree\Model\Iterator
 */
final class FilterByDirectionIterator extends \FilterIterator
{
    use MinMax;

    /**
     * FilterIterator constructor.
     *
     * @param BtreeNodeInterface $splitNode
     * @param BtreeNodeKeyInterface $key
     * @param \Iterator $iterator
     */
    public function __construct(
        private readonly BtreeNodeInterface $splitNode,
        private readonly BtreeNodeKeyInterface $key,
        public \Iterator $iterator
    ) {
        parent::__construct($iterator);
    }

    /** @inheritDoc */
    public function accept(): bool
    {
        $keyValue = $this->key->getValue();
        $splitNodeKeys = $this->splitNode->getKeys();
        $currentNodeKeys = $this->current()->getKeys();

        $splitNodeMaxKeyVal = $this->getMaxVal($splitNodeKeys);
        $splitNodeMInKeyVal = $this->getMinVal($splitNodeKeys);

        $maxParentNodeKeyVal = $this->getMaxVal($currentNodeKeys);
        $minParentNodeKeyVal = $this->getMaxVal($currentNodeKeys);

        $toLeftHand = $splitNodeMaxKeyVal < $keyValue && $maxParentNodeKeyVal < $keyValue;
        $toRightHand = $splitNodeMInKeyVal > $keyValue && $minParentNodeKeyVal > $keyValue;

        return $toLeftHand || $toRightHand;
    }
}