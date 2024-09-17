<?php

declare(strict_types=1);

namespace Play\Hard\Code\Utility;

use Play\Hard\Frame\Exception\FilesystemException;
use Play\Hard\Frame\System\FileSystem;

use function \filesystem\{file_put_contents, file_get_contents};

/**
 * @final FileManager
 *
 * @package Play\Hard\Code\Utility
 */
final readonly class FileManager
{
    /**
     * FileManager constructor.
     *
     * @param FileSystem $fileSystem
     * @param string $mediaFolder
     * @param string $fileFormat
     */
    public function __construct(
        private FileSystem $fileSystem,
        private string $mediaFolder,
        private string $fileFormat
    ) {}

    /**
     * Get file content
     *
     * @param string $folderWhereToTake
     * @param string $fileName
     *
     * @return string
     *
     * @throws FilesystemException
     */
    public function getContent(string $folderWhereToTake, string $fileName): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $folderWhereToTake = trim(trim($folderWhereToTake), $ds);
        $mediaFolderPath = $this->fileSystem->getFolderPath($this->mediaFolder);
        $filePath = $mediaFolderPath . $ds . $folderWhereToTake . $ds . $fileName;

        return file_get_contents($filePath);
    }

    /**
     * Write/put content to file
     *
     * @param string $folderWhereToPut
     * @param string $fileName
     * @param string $fileContent
     * @param string|null $ff
     * @return void
     *
     * @throws FilesystemException
     */
    public function putContent(string $folderWhereToPut, string $fileName, string $fileContent, string $ff = null): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $ff = trim($ff ?: $this->fileFormat, '.');
        $folderWhereToPut = trim(trim($folderWhereToPut), $ds);
        $mediaFolderPath = $this->fileSystem->getFolderPath($this->mediaFolder);
        $fileName = $ds . $mediaFolderPath . $ds . $folderWhereToPut . $ds . $fileName . '.' . $ff;

        file_put_contents($fileName, $fileContent);
    }

    /**
     * Put content into tmp folder
     *
     * @param string $path
     * @param string $content
     *
     * @return void
     *
     * @throws FilesystemException
     */
    public function tempo(string $path, string $content): void
    {
        file_put_contents($path, $content);
    }
}