<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model;

use Play\Hard\Code\Btree\Model\SiblingPoint\SiblingPointerInterface;
use Play\Hard\Code\Btree\Model\Factory\PointerFactory;
use Play\Hard\Code\Btree\Model\Trait\MinMax;
use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};

use function iter\{iterable_array, iterator_map};

/**
 * @final KeysLinkToNode
 *
 * @package Play\Hard\Code\Btree\Model\Balance
 */
final readonly class KeyNodeLinker implements KeyNodeLinkerInterface
{
    use MinMax;

    /**
     * KeyNodeLinker constructor.
     *
     * @param SiblingPointerInterface $siblingPointer
     * @param PointerFactory $pointerFactory
     */
    public function __construct(
        private SiblingPointerInterface $siblingPointer,
        private PointerFactory $pointerFactory
    ) {}

    /** @inheritDoc */
    public function link(BtreeNodeInterface $node): BtreeNodeInterface
    {
        $childNodes = [];
        $keysIterator = iterable_array(array_values($node->getKeys()));
        while ($currentKey = $keysIterator->current()) {
            $nextKey = null;
            $nextKeyIdx = $keysIterator->key() + 1;
            if ($keysIterator->offsetExists($nextKeyIdx)) {
                $nextKey = $keysIterator->offsetGet($nextKeyIdx);
            }

            $childNodes = $this->pointSiblingNode($node, $currentKey, $nextKey);

            $keysIterator->next();
        }

        if (!empty($childNodes)) {
            $node->setChildNodes($childNodes);
        }

        return $node;
    }

    /**
     * Based on the key value, assign/point child nodes to either the left or right direction
     *
     * @param BtreeNodeInterface $node
     * @param BtreeNodeKeyInterface $currentKey
     * @param BtreeNodeKeyInterface|null $nextKey
     *
     * @return array
     */
    private function pointSiblingNode(
        BtreeNodeInterface     $node,
        BtreeNodeKeyInterface  $currentKey,
        ?BtreeNodeKeyInterface $nextKey
    ): array {
        $pointedNodes = [];
        $childNodes = iterable_array($this->sort($node->getChildNodes()));

        foreach ($childNodes as $childNode) {
            $pointer = $this->pointerFactory->create($childNode, $currentKey, $nextKey);
            $currentKey = $this->siblingPointer->point($pointer);

            $node->addKey($currentKey);
            $childNode->setParentNode($node);

            $pointedNodes[$childNode->getUuid()] = $childNode;
        }

        return $pointedNodes;
    }

    /**
     * Sort nodes by their keys
     *
     * @param array $chNodes
     *
     * @return array<BtreeNodeInterface>
     */
    private function sort(array $chNodes): array
    {
        $fn = fn(BtreeNodeInterface $node) => [$this->getMaxVal($node->getKeys()) => $node];
        $chNds = iterator_map($fn, $chNodes, unpack: true, keep_keys: true);
        ksort($chNds);

        return $chNds;
    }
}