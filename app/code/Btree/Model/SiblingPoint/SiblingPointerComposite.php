<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\SiblingPoint;

use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    PointerInterface
};

/**
 * @final SiblingPointerComposite
 *
 * @package Play\Hard\Code\Btree\Model\SiblingPoint
 */
final readonly class SiblingPointerComposite implements SiblingPointerInterface
{
    /**
     * SiblingPointerComposite constructor.
     *
     * @param array<SiblingPointerInterface> $pointers
     */
    public function __construct(private array $pointers) {}

    /** @inheritDoc */
    public function point(PointerInterface $pointerModel): ?BtreeNodeKeyInterface
    {
        foreach ($this->pointers as $pointer) {
            $pointer->point($pointerModel);
        }

        # just return current key
        return $pointerModel->getCurrentKey();
    }
}