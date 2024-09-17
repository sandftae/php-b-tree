<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Balance;

use Play\Hard\Code\Btree\Api\{BtreeNodeKeyInterface, BtreeNodeInterface};

/**
 * @interface KeyManagerCompositeInterface
 *
 * @package Play\Hard\Code\Btree\Model\Balance
 */
interface KeyManagerCompositeInterface
{
    /**
     * Find the position for the key and place/position the key in the tree
     *
     * @param BtreeNodeInterface $node
     * @param BtreeNodeKeyInterface $keyCandidate
     *
     * @return BtreeNodeInterface
     */
    public function doKeyPosition(BtreeNodeInterface $node, BtreeNodeKeyInterface $keyCandidate): BtreeNodeInterface;
}