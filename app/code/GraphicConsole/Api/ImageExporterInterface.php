<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Api;

use Play\Hard\Frame\Exception\FilesystemException;
use Graphviz\InstructionInterface;

/**
 * @interface ImageExporterInterface
 *
 * @package Play\Hard\Code\GraphicConsole\Api
 */
interface ImageExporterInterface
{
    /**
     * The image export is based on the graph layout given
     *
     * @param InstructionInterface $digraph
     *
     * @return void
     *
     * @throws FilesystemException
     */
    public function export(InstructionInterface $digraph): void;
}