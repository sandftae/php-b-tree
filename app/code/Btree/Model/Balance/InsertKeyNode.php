<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Balance;

use Play\Hard\Code\Btree\Api\{BtreeNodeKeyInterface, BtreeNodeInterface};

/**
 * @final InsertKeyNode
 *
 * @package Play\Hard\Code\Btree\Api\BtreeNodeKeyInterface
 */
final class InsertKeyNode implements KeyManagerCompositeInterface
{
    /** @inheritDoc */
    public function doKeyPosition(BtreeNodeInterface $node, BtreeNodeKeyInterface $keyCandidate): BtreeNodeInterface
    {
        if(!$node->isOverflow()) {
            $node->addKey($keyCandidate);
        }

        return $node;
    }
}