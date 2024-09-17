<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Balance;

use Play\Hard\Code\Btree\Model\Balance\Utility\Split as SplitUtility;
use Play\Hard\Code\Btree\Model\KeyNodeLinkerInterface;
use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};

use function iter\iterator_map;
use function func\find_median;

/**
 * @final KeySplitsNode
 *
 * @package Play\Hard\Code\Btree\Model\Balance
 */
final readonly class KeySplitsNode implements KeyManagerCompositeInterface
{
    /**
     * KeySplitsNode constructor.
     *
     * @param KeyNodeLinkerInterface $keyNodeLinker
     * @param SplitUtility $splitUtility
     */
    public function __construct(
        private KeyNodeLinkerInterface $keyNodeLinker,
        private SplitUtility $splitUtility
    ) {}

    /** @inheritDoc */
    public function doKeyPosition(BtreeNodeInterface $node, BtreeNodeKeyInterface $keyCandidate): BtreeNodeInterface
    {
        if ($node->isOverflow()) {
            return $this->reverseDirection($node);
        }

        return $node;
    }

    /**
     * Go up the tree once the lowest child of tree has been reached
     *
     * @param BtreeNodeInterface $node
     *
     * @return BtreeNodeInterface
     */
    private function reverseDirection(BtreeNodeInterface $node): BtreeNodeInterface
    {
        $splitNodes = [];
        $parentNode = $node->getParentNode();

        if ($parentNode->isRoot()) {
            # the tree should have only one root node; once the top of the tree is reached,
            # we need to create another node "first after the root" - a top child node
            $parentNode = $parentNode->getPureNode()->setParentNode($parentNode);
        }

        $childNodes = $node->getChildNodes();
        $overflowedNodeKeys = $node->getKeys();
        $keyToGoUpTheTree = find_median($overflowedNodeKeys);
        $splitKeys = $this->splitUtility->extractSplitKeys($keyToGoUpTheTree, $overflowedNodeKeys);

        foreach ($splitKeys as $keys) {
            $nodeCandidate = $node->getPureNode()->setParentNode($parentNode)->setKeys($keys);

            if ($childNodes) {
                $nodeCandidate = $this->addSplitChildNode($nodeCandidate, $keyToGoUpTheTree, $childNodes);
            }

            $splitNodes[$nodeCandidate->getUuid()] = $nodeCandidate;
        }

        $existsParentChildNodes = $parentNode->removeNode($node->getUuid())->getChildNodes();
        $clearedParentChildNodes = array_merge($existsParentChildNodes, $splitNodes);

        $parentNode->addKey($keyToGoUpTheTree)->setChildNodes($clearedParentChildNodes);

        if ($parentNode->isOverflow()) {
            return $this->reverseDirection($parentNode);
        }

        return $this->keyNodeLinker->link($parentNode);
    }

    /**
     * Add split Child node
     *
     * @param BtreeNodeInterface $splitNode
     * @param BtreeNodeKeyInterface $keyToDivideBy
     * @param array $nodes
     *
     * @return BtreeNodeInterface
     */
    private function addSplitChildNode(
        BtreeNodeInterface    $splitNode,
        BtreeNodeKeyInterface $keyToDivideBy,
        array $nodes
    ): BtreeNodeInterface {
        $filterableNodes = $this->splitUtility->buildFilterableNodes($keyToDivideBy, $splitNode, $nodes);

        $fn = fn(BtreeNodeInterface $node) => [$node->getUuid() => $node->setParentNode($splitNode)];

        $splitChildNodes = iterator_map($fn, $filterableNodes, true);

        return $this->keyNodeLinker->link($splitNode->setChildNodes($splitChildNodes));
    }
}