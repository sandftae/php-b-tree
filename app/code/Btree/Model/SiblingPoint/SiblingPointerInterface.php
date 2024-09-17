<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\SiblingPoint;

use Play\Hard\Code\Btree\Api\{BtreeNodeKeyInterface, PointerInterface};

/**
 * @interface SiblingPointerInterface
 *
 * @package Play\Hard\Code\Btree\Model\SiblingPoint
 */
interface SiblingPointerInterface
{
    /**
     * Pointing of a sibling node point relative to a Pointer model given
     *
     * @param PointerInterface $pointerModel
     *
     * @return BtreeNodeKeyInterface|null
     */
    public function point(PointerInterface $pointerModel): ?BtreeNodeKeyInterface;
}