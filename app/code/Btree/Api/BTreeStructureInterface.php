<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Api;

/**
 * @interface BTreeStructureInterface
 *
 * @package Play\Hard\Code\Btree\Api
 */
interface BTreeStructureInterface
{
    /**
     * Do node and leafs balancing up the tree
     *
     * @return BTreeStructureInterface
     */
    public function doBalancing(): BTreeStructureInterface;

    /**
     * Return node graph
     *
     * @return BtreeNodeInterface
     */
    public function getTreeNode(): BtreeNodeInterface;

    /**
     * Set node graph
     *
     * @param BtreeNodeInterface $btreeNode
     *
     * @return BTreeStructureInterface
     */
    public function setTreeNode(BtreeNodeInterface $btreeNode): BTreeStructureInterface;

    /**
     * Set candidate to be added to the tree
     *
     * @param BtreeNodeKeyInterface $nodeKey
     *
     * @return BTreeStructureInterface
     */
    public function addCandidate(BtreeNodeKeyInterface $nodeKey): BTreeStructureInterface;

    /**
     * Get candidate
     *
     * @return BtreeNodeKeyInterface|null
     */
    public function getCandidate(): ?BtreeNodeKeyInterface;
}