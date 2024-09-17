<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model;

use Play\Hard\Code\Btree\Api\BtreeNodeInterface;

/**
 * @interface KeyNodeLinkerInterface
 *
 * @package Play\Hard\Code\Btree\Api
 */
interface KeyNodeLinkerInterface
{
    /**
     * Link all node`s keys to child nodes
     *
     * @param BtreeNodeInterface $node
     *
     * @return BtreeNodeInterface
     */
    public function link(BtreeNodeInterface $node): BtreeNodeInterface;
}