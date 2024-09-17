<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole;

use Play\Hard\Code\GraphicConsole\Api\LabelHolderInterface;
use Play\Hard\Code\Btree\Api\BtreeNodeKeyInterface;

/**
 * @final LabelHolder
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph
 */
final class LabelHolder implements LabelHolderInterface
{
    /**
     * LabelHolder constructor.
     *
     * @param BtreeNodeKeyInterface|null $key
     * @param bool $isRightEdge
     * @param bool $isLeftEdge
     * @param array $labelString
     */
    public function __construct(
        private ?BtreeNodeKeyInterface $key = null,
        private bool $isRightEdge = false,
        private bool $isLeftEdge = false,
        private array $labelString = []
    ) {}

    /** @inheritDoc */
    public function setKey(BtreeNodeKeyInterface $key): LabelHolderInterface
    {
        $this->key = $key;

        return $this;
    }

    /** @inheritDoc */
    public function getKey(): ?BtreeNodeKeyInterface
    {
        return $this->key;
    }

    /** @inheritDoc */
    public function addLabelSubString(string $subString): LabelHolderInterface
    {
        $this->labelString[] = $subString;

        return $this;
    }

    /** @inheritDoc */
    public function getLabel(): string
    {
        return implode('', $this->labelString);
    }

    /** @inheritDoc */
    public function isRightEdge(?bool $isRightEdge = null): bool
    {
        if (!is_null($isRightEdge)) {
            $this->isRightEdge = $isRightEdge;
        }

        return $this->isRightEdge;
    }

    /** @inheritDoc */
    public function isLeftEdge(?bool $isLeftEdge = null): bool
    {
        if (!is_null($isLeftEdge)) {
            $this->isLeftEdge = $isLeftEdge;
        }

        return $this->isLeftEdge;
    }
}