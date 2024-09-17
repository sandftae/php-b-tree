<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Api;

/**
 * @interface BtreeNodeInterface
 *
 * @package Play\Hard\Code\Btree\Api
 */
interface BtreeNodeInterface
{
    /**
     * Is the node root one?
     *
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * Check if the node is overflow and should be split
     *
     * @return bool
     */
    public function isOverflow(): bool;

    /**
     * Set leaf for the node
     *
     * @param BtreeNodeKeyInterface $nodeKey
     *
     * @return BtreeNodeInterface
     */
    public function addKey(BtreeNodeKeyInterface $nodeKey): BtreeNodeInterface;

    /**
     * Set keys
     *
     * @param array<BtreeNodeKeyInterface> $keys
     *
     * @return BtreeNodeInterface
     */
    public function setKeys(array $keys): BtreeNodeInterface;

    /**
     * Get all leafs belong to the node
     *
     * @return array<BtreeNodeKeyInterface>
     */
    public function getKeys(): array;

    /**
     * Get new node containing links to the parent node
     *
     * @return BtreeNodeInterface
     */
    public function getPureNode(): BtreeNodeInterface;

    /**
     * Get capacity allowed of the node
     *
     * @return int
     */
    public function getCapacity(): int;

    /**
     * Get the node unique uuid
     *
     * @return string
     */
    public function getUuid(): string;


    /**
     * Get child nodes
     *
     * @return array<BtreeNodeInterface>
     */
    public function getChildNodes(): array;

    /**
     * Store list of child nodes
     *
     * @param array<BtreeNodeInterface> $childNodes
     *
     * @return BtreeNodeInterface
     */
    public function setChildNodes(array $childNodes): BtreeNodeInterface;

    /**
     * Remove child node by child node`s uuid
     *
     * @param string $uuid
     *
     * @return BtreeNodeInterface
     */
    public function removeNode(string $uuid): BtreeNodeInterface;

    /**
     * Set parent node
     *
     * @param BtreeNodeInterface|null $node
     *
     * @return BtreeNodeInterface
     */
    public function setParentNode(?BtreeNodeInterface $node): BtreeNodeInterface;

    /**
     * Get parent node
     *
     * @return BtreeNodeInterface|null
     */
    public function getParentNode(): ?BtreeNodeInterface;
}