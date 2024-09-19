<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Cli;

use Play\Hard\Frame\ObjectManagerInvoker;
use Play\Hard\Frame\Cli\Spi\{
    ArgumentProviderInterface,
    ConsoleManagerInterface
};

/**
 * @final class ConsoleManagerPool
 *
 * @package Play\Hard\Frame\Cli
 */
final readonly class ConsoleManagerPool implements ConsoleManagerPoolInterface
{
    /** @const int */
    public const SUCCESS_CODE = 0;

    /**
     * ConsoleManagerPool constructor
     *
     * @param array<ConsoleManagerInterface> $cliCommands
     * @param string $usageMessage
     * @param string $defaultCapacity
     */
    public function __construct(
        private array  $cliCommands,
        private string $usageMessage,
        private string $defaultCapacity
    ) {}

    /** @inheritDoc */
    public function doRun(): int
    {
        if (!$options = getopt('t:c:s:f:dg')) {
            $this->usageHowTow();
        }

        $cliCommandType = $options['t'] ?? null;

        if (!$cliCommandType || !$this->cliCommands[strtolower($cliCommandType)]) {
            $this->usageHowTow();
        }

        $cliCommand = $this->cliCommands[strtolower($cliCommandType)];
        $argumentProvider = $this->builtArguments($options);

        $cliCommand->run($argumentProvider);

        return self::SUCCESS_CODE;
    }

    /**
     * Built Argument Provider with arguments given
     *
     * @param array $options
     *
     * @return ArgumentProviderInterface|object
     */
    private function builtArguments(array $options): ArgumentProviderInterface
    {
        $defaultCapacity = (int) $this->defaultCapacity;
        $numSet = $options['s'] ?? [];
        $dumpRequested = isset($options['d']);
        $graphicRequested = isset($options['g']);
        $fileToLoadFrom = $options['f'] ?? null;
        $capacity = (int) isset($options['c']) ? $options['c'] : $defaultCapacity;

        if ($numSet) {
            $numSet = array_map(fn($argument) => trim($argument), explode(',', $numSet));
        }

        $objectContainer = ObjectManagerInvoker::getInstance();

        /** @return ArgumentProviderInterface */
        return $objectContainer->get(
            ArgumentProviderInterface::class,
            [
                'graphicRequested' => $graphicRequested,
                'fileNameToLoad' => $fileToLoadFrom ? trim($fileToLoadFrom) : '',
                'dumpRequested' => $dumpRequested,
                'capacity' => max($capacity, $defaultCapacity),
                'numSet' => $numSet
            ]
        );
    }

    /**
     * Show general notification of how to use
     *
     * @return never
     */
    private function usageHowTow(): never
    {
        $tab = chr(9);
        # >= )
        exit(
            sprintf(
                $this->usageMessage,
                PHP_EOL,
                $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, $tab, PHP_EOL,
                $tab, $tab, $tab, $tab, $tab, PHP_EOL,
                PHP_EOL, $tab, $tab,
                PHP_EOL, PHP_EOL, $tab, $tab,
                PHP_EOL, $tab, $tab,
                PHP_EOL, PHP_EOL, $tab, $tab,
                PHP_EOL, PHP_EOL, $tab, $tab, PHP_EOL, PHP_EOL
            )
        );
    }
}