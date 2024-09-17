<?php

declare(strict_types=1);

namespace Play\Hard\Frame\System;

use Play\Hard\Frame\Exception\FilesystemException;

/**
 * @final FileSystem
 *
 * @package Play\Hard\Frame\System
 */
final class FileSystem
{
    /**
     * FileSystem constructor.
     *
     * @param string|null $baseDirPath
     * @param array $rootSubPath
     */
    public function __construct(
        private ?string $baseDirPath = null,
        private array $rootSubPath = []
    ) {}

    /**
     * Get Root/Base path of the project
     *
     * @return string
     */
    public function getBasePath(): string
    {
        if(!isset($this->baseDirPath)) {
            $frameDir = dirname(__DIR__);
            $this->baseDirPath = dirname($frameDir, 2);
        }

        return $this->baseDirPath;
    }

    /**
     * Get folder path from root/base folder
     *
     * @param string $folderName
     *
     * @return string
     *
     * @throws FilesystemException
     */
    public function getFolderPath(string $folderName): string
    {
        $folderName = trim(trim($folderName), '/');
        if (isset($this->rootSubPath[$folderName])) {
            return $this->rootSubPath[$folderName];
        }

        $folderPath = $this->getBasePath() . DIRECTORY_SEPARATOR . $folderName;
        if (!file_exists($folderPath)) {
            throw new FilesystemException(
                sprintf(
                    'This folder [%s] does not exists or is not sub-folder of the root one.',
                    $folderName
                )
            );
        }

        $this->rootSubPath[$folderName] = $folderPath;

        return $folderPath;
    }
}