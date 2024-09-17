<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Api;

use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Graphviz\InstructionInterface;

/**
 * @interface LabelEdgeProcessorInterface
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph
 */
interface LabelAssemblerProcessorInterface
{
    /**
     * Build a record/label for the digraph to build a
     *
     * @param LabelHolderInterface $labelHolder
     * @param BtreeNodeInterface $node
     * @param InstructionInterface $graph
     *
     * @return LabelHolderInterface
     */
    public function assemble(
        LabelHolderInterface $labelHolder,
        BtreeNodeInterface $node,
        InstructionInterface $graph
    ): LabelHolderInterface;
}