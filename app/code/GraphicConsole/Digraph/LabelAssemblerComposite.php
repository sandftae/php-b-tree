<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Digraph;

use Play\Hard\Code\GraphicConsole\Api\LabelAssemblerProcessorInterface;
use Play\Hard\Code\GraphicConsole\Api\LabelHolderInterface;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Graphviz\InstructionInterface;

/**
 * @final LabelEdgeComposite
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph
 */
final readonly class LabelAssemblerComposite implements LabelAssemblerProcessorInterface
{
    /**
     * LabelEdgeComposite constructor.
     *
     * @param array<LabelAssemblerProcessorInterface> $processors
     */
    public function __construct(private array $processors) {}

    /** @inheritDoc */
    public function assemble(
        LabelHolderInterface $labelHolder,
        BtreeNodeInterface $node,
        InstructionInterface $graph
    ): LabelHolderInterface {
        foreach ($this->processors as $labelEdgeProcessor) {
            $labelHolder = $labelEdgeProcessor->assemble($labelHolder, $node, $graph);
        }

        return $labelHolder;
    }
}