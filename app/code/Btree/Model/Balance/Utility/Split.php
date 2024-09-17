<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Balance\Utility;

use Play\Hard\Code\Btree\Api\{BtreeNodeKeyInterface, BtreeNodeInterface};
use Play\Hard\Code\Btree\Model\Iterator\FilterByDirectionIterator;

use function iter\iterable_array;

/**
 * @final Split
 *
 * @package Play\Hard\Code\Btree\Model\Balance\Utility
 */
final readonly class Split
{
    /**
     * Extract split keys to add to split nodes later
     *
     * @param BtreeNodeKeyInterface $nodeKey
     * @param array $overflowedNodeKeys
     *
     * @return BtreeNodeKeyInterface[][]
     */
    public function extractSplitKeys(BtreeNodeKeyInterface $nodeKey, array $overflowedNodeKeys): array
    {
        $leftHandKeys = [];
        $rightHandKeys = [];

        /** @var BtreeNodeKeyInterface $key */
        foreach ($overflowedNodeKeys as $key) {
            if ($nodeKey->getValue() > $key->getValue()) {
                $leftHandKeys[$key->getValue()] = $key;
            }

            if ($nodeKey->getValue() < $key->getValue()) {
                $rightHandKeys[$key->getValue()] = $key;
            }
        }

        return [$leftHandKeys, $rightHandKeys];
    }

    /**
     * Create a FilterIterator for the given nodes. It will help to extract nodes based on the conditions defined
     * on the iterator and will help to reduce the steps in case of a simple iterator.
     *
     * @param BtreeNodeKeyInterface $key
     * @param BtreeNodeInterface $splitNode
     * @param array $nodes
     *
     * @return FilterByDirectionIterator
     */
    public function buildFilterableNodes(BtreeNodeKeyInterface $key, BtreeNodeInterface $splitNode, array $nodes): FilterByDirectionIterator
    {
        return (new FilterByDirectionIterator($splitNode, $key, iterable_array($nodes)));
    }
}