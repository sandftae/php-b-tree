<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\SiblingPoint;

use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    PointerInterface
};

/**
 * @final InBetweenPointer
 *
 * @package Play\Hard\Code\Btree\Model\SiblingPoint
 */
final readonly class InBetweenPointer implements SiblingPointerInterface
{
    /** @inheritDoc */
    public function point(PointerInterface $pointerModel): ?BtreeNodeKeyInterface
    {
        if ($pointerModel->isInBetweenPosition()) {
            return $pointerModel->getCurrentKey()->setRightNode($pointerModel->getNode());
        }

        return null;
    }
}