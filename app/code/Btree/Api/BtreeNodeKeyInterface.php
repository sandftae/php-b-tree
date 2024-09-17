<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Api;

/**
 * @interface BtreeNodeKeyInterface
 *
 * @package Play\Hard\Code\Btree\Api
 */
interface BtreeNodeKeyInterface
{
    /**
     * Get Key Value
     *
     * @return int
     */
    public function getValue(): int;

    /**
     * Get left node
     *
     * @return BtreeNodeInterface|null
     */
    public function getLeftNode(): ?BtreeNodeInterface;

    /**
     * Set left node
     *
     * @param BtreeNodeInterface $node
     *
     * @return BtreeNodeKeyInterface
     */
    public function setLeftNode(BtreeNodeInterface $node): BtreeNodeKeyInterface;

    /**
     * Get right node
     *
     * @return BtreeNodeInterface|null
     */
    public function getRightNode(): ?BtreeNodeInterface;

    /**
     * Set right node
     *
     * @param BtreeNodeInterface $node
     *
     * @return BtreeNodeKeyInterface
     */
    public function setRightNode(BtreeNodeInterface $node): BtreeNodeKeyInterface;
}