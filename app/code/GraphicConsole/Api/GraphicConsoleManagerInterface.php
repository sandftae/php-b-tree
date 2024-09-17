<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Api;

use Play\Hard\Frame\Exception\FilesystemException;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;

/**
 * @interface GraphicConsoleManagerInterface
 *
 * @package Play\Hard\Code\GraphicConsole
 */
interface GraphicConsoleManagerInterface
{
    /**
     * Draw B-Tree graphic representation
     *
     * @param BtreeNodeInterface $node
     *
     * @return void
     *
     * @throws FilesystemException
     */
    public function draw(BtreeNodeInterface $node): void;
}