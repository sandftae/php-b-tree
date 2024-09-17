<?php

declare(strict_types=1);

namespace Play\Hard\Code\Dump;

use Play\Hard\Frame\Exception\{FilesystemException, JsonException};
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;

/**
 * @interface DataDumperInterface
 *
 * @package Play\Hard\Code\Dump
 */
interface DataDumperInterface
{
    /**
     * Dump B-Tree node given
     *
     * @param BtreeNodeInterface $node
     *
     * @return void
     *
     * @throws FilesystemException | JsonException
     */
    public function dump(BtreeNodeInterface $node): void;
}