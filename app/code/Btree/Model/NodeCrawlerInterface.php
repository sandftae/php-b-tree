<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model;

use Play\Hard\Code\Btree\Api\BtreeNodeKeyInterface;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;

/**
 * @interface NodeCrawlerInterface
 *
 * @package Play\Hard\Code\Btree\Api
 */
interface NodeCrawlerInterface
{
    /**
     * Recursively walk through the nodes provided
     *
     * @param BtreeNodeKeyInterface $keyCandidate
     * @param BtreeNodeInterface $rootNode
     *
     * @return BtreeNodeInterface
     */
    public function run(BtreeNodeKeyInterface $keyCandidate, BtreeNodeInterface $rootNode): BtreeNodeInterface;
}