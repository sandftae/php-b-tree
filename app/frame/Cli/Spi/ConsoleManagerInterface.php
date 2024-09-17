<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Cli\Spi;

/**
 * @interface ConsoleManagerInterface
 *
 * @@package  Play\Hard\Frame\Cli\Spi
 *
 * @description:
 * The SPI interface that Console Manager classes must implement to use
 */
interface ConsoleManagerInterface
{
    /**
     * Run CLI Command Console Manager
     *
     * @param ArgumentProviderInterface $argumentProvider
     *
     * @return void
     */
     public function run(ArgumentProviderInterface $argumentProvider): void;
}