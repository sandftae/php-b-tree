<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model;

use Play\Hard\Code\Btree\Model\Balance\KeyManagerCompositeInterface;
use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};

use function iter\iterable_array;

/**
 * @final NodeCrawler
 *
 * @package Play\Hard\Code\Btree\Model
 */
final readonly class NodeCrawler implements NodeCrawlerInterface
{
    /**
     * NodeCrawler constructor.
     *
     * @param KeyManagerCompositeInterface $keyManager
     */
    public function __construct(private KeyManagerCompositeInterface $keyManager) {}

    /** @inheritDoc */
    public function run(BtreeNodeKeyInterface $keyCandidate, BtreeNodeInterface $rootNode): BtreeNodeInterface
    {
        return $this->extractRoot($this->walk($rootNode, $keyCandidate));
    }

    /**
     * Walk through the node given down the path
     *
     * @param BtreeNodeInterface $node
     * @param BtreeNodeKeyInterface $keyCandidate
     *
     * @return BtreeNodeInterface
     */
    private function walk(BtreeNodeInterface $node, BtreeNodeKeyInterface $keyCandidate): BtreeNodeInterface
    {
        # once the lowest trees node has been reached try to position the new key in the node
        if (!$node->getChildNodes()) {
            return $this->keyManager->doKeyPosition($node, $keyCandidate);
        }

        $result = null;
        $nodeKeysIterator = iterable_array(array_values($node->getKeys()));
        while($key = $nodeKeysIterator->current()) {
            $nextKeyExists = $nodeKeysIterator->offsetExists($nodeKeysIterator->key() + 1);
            $direction = $keyCandidate->getValue() > $key->getValue();

            if($result) {
                return $result;
            }

            if (!$nextKeyExists) {
                $result = $direction ? $this->walk($key->getRightNode(), $keyCandidate) : $this->walk($key->getLeftNode(), $keyCandidate);
            }

            if (!$direction && $nextKeyExists) {
                $result = $this->walk($key->getLeftNode(), $keyCandidate);
            }

            $nodeKeysIterator->next();
        }

        # garbage
        unset($node, $nodeKeysIterator, $keyCandidate);

        return $result;
    }

    /**
     * Extract root tree assigned to the node given
     *
     * @param BtreeNodeInterface $node
     *
     * @return BtreeNodeInterface
     */
    private function extractRoot(BtreeNodeInterface $node): BtreeNodeInterface
    {
        $parentNode = $node->getParentNode();
        if ($parentNode->isRoot()) {
            return $node;
        }

        return $this->extractRoot($parentNode);
    }
}