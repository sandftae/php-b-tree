<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Api;

use Play\Hard\Code\Btree\Api\BtreeNodeKeyInterface;

/**
 * @interface LabelHolderInterface
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph\Api
 */
interface LabelHolderInterface
{
    /**
     * Set key to use
     *
     * @param BtreeNodeKeyInterface $key
     *
     * @return LabelHolderInterface
     */
    public function setKey(BtreeNodeKeyInterface $key): LabelHolderInterface;

    /**
     * Get key to use
     *
     * @return BtreeNodeKeyInterface|null
     */
    public function getKey(): ?BtreeNodeKeyInterface;

    /**
     * Add label`s sub-string
     *
     * @param string $subString
     *
     * @return LabelHolderInterface
     */
    public function addLabelSubString(string $subString): LabelHolderInterface;

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Set/Get is right edge value
     *
     * @param bool|null $isRightEdge
     *
     * @return bool
     */
    public function isRightEdge(?bool $isRightEdge = null): bool;

    /**
     * Set/Get is left edge value
     *
     * @param bool|null $isLeftEdge
     *
     * @return bool
     */
    public function isLeftEdge(?bool $isLeftEdge = null): bool;
}