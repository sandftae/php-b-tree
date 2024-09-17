<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Api;

/**
 * @interface PointerInterface
 *
 * @package Play\Hard\Code\Btree\Api
 */
interface PointerInterface
{
    /**
     * Get left or right direction; it is true or false state
     *
     * @return bool
     */
    public function getDirection(): bool;

    /**
     * Get current key assigned
     *
     * @return BtreeNodeKeyInterface
     */
    public function getCurrentKey(): BtreeNodeKeyInterface;

    /**
     * Get next door key
     *
     * @return BtreeNodeKeyInterface|null
     */
    public function getNextKey(): ?BtreeNodeKeyInterface;

    /**
     * Get node assigned
     *
     * @return BtreeNodeInterface
     */
    public function getNode(): BtreeNodeInterface;

    /**
     * Is this point has in-between position?
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function isInBetweenPosition(): bool;
}