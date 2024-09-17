<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Cli\Argument;

use Play\Hard\Frame\Cli\Spi\ArgumentProviderInterface;
use Play\Hard\Frame\Exception\FilesystemException;
use Play\Hard\Code\Utility\FileManager;

/**
 * @final ArgumentProvider
 *
 * @package Play\Hard\Frame\Cli\Argument
 */
final readonly class ArgumentProvider implements ArgumentProviderInterface
{
    /**
     * ArgumentProvider constructor.
     *
     * @param FileManager $fileManager
     * @param string $dirName
     * @param array $numSet
     * @param int $capacity
     * @param bool $dumpRequested
     * @param bool $graphicRequested
     * @param string|null $fileNameToLoad
     */
    public function __construct(
        private FileManager $fileManager,
        private bool        $graphicRequested,
        private ?string     $fileNameToLoad,
        private bool        $dumpRequested,
        private int         $capacity,
        private string      $dirName,
        private array       $numSet,
    ) {}

    /** @inheritDoc */
    public function numSet(): array
    {
        if ($this->fileNameToLoad && $this->numSetFromFile()) {
            return $this->numSetFromFile();
        }

        if ($this->numSetFromCli()) {
            return $this->numSetFromCli();
        }

        return range(-100, 100);
    }

    /** @inheritDoc */
    public function capacity(): int
    {
        return (int) $this->capacity;
    }

    /** @inheritDoc */
    public function graphDumpRequested(): bool
    {
        return (bool) $this->dumpRequested;
    }

    /** @inheritDoc */
    public function graphImageRequested(): bool
    {
        return (bool) $this->graphicRequested;
    }

    /**
     * Check the numSet given by CLI
     *
     * @return array
     */
    private function numSetFromCli(): array
    {
        return $this->numSet;
    }

    /**
     * Check the numSet given by a file
     *
     * @return array
     *
     * @throws FilesystemException
     */
    private function numSetFromFile(): array
    {
        $jsonString = $this->fileManager->getContent($this->dirName, $this->fileNameToLoad);

        if (!$jsonString) {
            return [];
        }

        return json_decode($jsonString);
    }
}