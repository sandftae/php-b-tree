<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\TreeElement;

use Play\Hard\Code\Btree\Model\NodeCrawlerInterface;

use Play\Hard\Code\Btree\Api\{
    BTreeStructureInterface,
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};

/**
 * @final BTreeStructure
 *
 * @package Play\Hard\Code\Btree\Model\TreeElement\BTreeStructure
 */
final class BTreeStructure implements BTreeStructureInterface
{
    /**
     * BTreeStructure constructor.
     *
     * @param NodeCrawlerInterface $nodeCrawler
     * @param BtreeNodeInterface $treeNode
     * @param BtreeNodeKeyInterface|null $nodeKey
     */
    public function __construct(
        private readonly NodeCrawlerInterface $nodeCrawler,
        private BtreeNodeInterface $treeNode,
        private ?BtreeNodeKeyInterface $nodeKey = null
    ) {}

    /** @inheritDoc */
    public function doBalancing(): BTreeStructureInterface
    {
        $node = $this->nodeCrawler->run(
            $this->getCandidate(),
            $this->getTreeNode()
        );

        $this->setTreeNode($node);

        return $this;
    }

    /** @inheritDoc */
    public function getTreeNode(): BtreeNodeInterface
    {
        return $this->treeNode;
    }

    /** @inheritDoc */
    public function setTreeNode(BtreeNodeInterface $btreeNode): BTreeStructureInterface
    {
        $this->treeNode = $btreeNode;
        return $this;
    }

    /** @inheritDoc */
    public function addCandidate(BtreeNodeKeyInterface $nodeKey): BTreeStructureInterface
    {
        $this->nodeKey = $nodeKey;

        return $this;
    }

    /** @inheritDoc */
    public function getCandidate(): ?BtreeNodeKeyInterface
    {
        return $this->nodeKey;
    }
}