<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Cli\Spi;

/**
 * @interface ArgumentProviderInterface
 *
 * @package Play\Hard\Frame\Cli\Spi
 */
interface ArgumentProviderInterface
{
    /**
     * Give an arguments set to use
     *
     * @return array
     */
    public function numSet(): array;

    /**
     * Get capacity predefined
     *
     * @return int
     */
    public function capacity(): int;

    /**
     * Is it need to dump the tree in json-look format
     *
     * @return bool
     */
    public function graphDumpRequested(): bool;

    /**
     * is it necessary to build a graphic image of a tree
     *
     * @return bool
     */
    public function graphImageRequested(): bool;
}