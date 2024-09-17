<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\SiblingPoint;

use Play\Hard\Code\Btree\Api\{
    BtreeNodeKeyInterface,
    PointerInterface
};

/**
 * @final LeftEdgePointer
 *
 * @package Play\Hard\Code\Btree\Model\SiblingPoint
 */
final readonly class LeftEdgePointer implements SiblingPointerInterface
{
    /** @inheritDoc */
    public function point(PointerInterface $pointerModel): ?BtreeNodeKeyInterface
    {
        if (!$pointerModel->getDirection()) {
            return $pointerModel->getCurrentKey()->setLeftNode($pointerModel->getNode());
        }

        return null;
    }
}