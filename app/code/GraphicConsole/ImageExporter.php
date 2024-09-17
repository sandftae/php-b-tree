<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole;

use Play\Hard\Code\GraphicConsole\Api\ImageExporterInterface;
use Play\Hard\Frame\Exception\FilesystemException;
use Play\Hard\Code\Utility\FileManager;
use Graphviz\InstructionInterface;

/**
 * @final ImageExporter
 *
 * @package Play\Hard\Code\GraphicConsole
 */
final readonly class ImageExporter implements ImageExporterInterface
{
    /**
     * ImageExporter constructor.
     *
     * @param FileManager $fileManager
     * @param string $imageFormat
     * @param string $imageName
     * @param string $executor
     * @param string $folder
     */
    public function __construct(
        private FileManager $fileManager,
        private string $imageFormat,
        private string $imageName,
        private string $executor,
        private string $folder
    ) {}

    /** @inheritDoc */
    public function export(InstructionInterface $digraph): void
    {
        $imageName = sprintf('%s_%s', $this->imageName, date('Y-m-d-H:i:s'));

        $execResults = $this->deployGraph($digraph);

        $this->fileManager->putContent(
            $this->folder,
            $imageName,
            $execResults,
            $this->imageFormat
        );
    }

    /**
     * Deploy the graph to create an image based on it
     *
     * @param InstructionInterface $digraph
     *
     * @return string
     *
     * @throws FilesystemException
     */
    private function deployGraph(InstructionInterface $digraph): string
    {
        if (!($tmp = tempnam($this->folder, 'phptree-export-'))) {
            return '';
        }

        # put the file into tmp folder
        $this->fileManager->tempo($tmp, $digraph->render());

        # and execute the file to actually build the graph
        return (string) shell_exec($this->getConvertCommand($tmp));
    }

    /**
     * Get CLI command converted
     *
     * @param string $path
     *
     * @return string
     */
    private function getConvertCommand(string $path): string
    {
        return sprintf('%s -T%s %s', $this->executor, $this->imageFormat, $path);
    }
}