<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Cli;

/**
 * @interface ConsoleManagerPoolInterface
 *
 * @package Play\Hard\Frame\Cli
 */
interface ConsoleManagerPoolInterface
{
    /**
     * Up CLI flow processing
     *
     * @return int
     *
     * @throws \Exception
     */
    public function doRun(): int;
}