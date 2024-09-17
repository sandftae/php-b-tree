<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole;

use Play\Hard\Code\GraphicConsole\Factory\LabelHolderFactory;
use Play\Hard\Code\GraphicConsole\Api\ImageExporterInterface;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Play\Hard\Code\GraphicConsole\Api\{
    LabelAssemblerProcessorInterface,
    GraphicConsoleManagerInterface
};
use Graphviz\InstructionInterface;
use Graphviz\Digraph;

use function iter\iterable_array;

/**
 * @final GraphicConsole
 *
 * @package Play\Hard\Code\GraphicConsole
 */
final readonly class GraphicConsole implements GraphicConsoleManagerInterface
{
    /**
     * GraphicConsole constructor.
     *
     * @param LabelAssemblerProcessorInterface $labelAssemblerProcessor
     * @param ImageExporterInterface $imageExporter
     * @param LabelHolderFactory $labelHolderFactory
     * @param Digraph $digraph
     */
    public function __construct(
        private LabelAssemblerProcessorInterface $labelAssemblerProcessor,
        private ImageExporterInterface $imageExporter,
        private LabelHolderFactory $labelHolderFactory,
        private Digraph $digraph
    ) {}

    /** @inheritDoc */
    public function draw(BtreeNodeInterface $node): void
    {
        $diGraphLayout = $this->prepareGraphLayout($node, $this->digraph);
        $this->imageExporter->export($diGraphLayout);
    }

    /**
     * Assemble a digraph layout [DOT] with the data needed to build the actual graph
     *
     * @param BtreeNodeInterface $node
     * @param InstructionInterface $graph
     *
     * @return InstructionInterface
     */
    private function prepareGraphLayout(BtreeNodeInterface $node, InstructionInterface $graph): InstructionInterface
    {
        $graph = $this->addLabel($node, $graph);

        foreach ($node->getChildNodes() as $node) {
            $graph = $this->prepareGraphLayout($node, $graph);
        }

        return $graph;
    }

    /**
     * Add label/record/nodes the graph node
     *
     * @param BtreeNodeInterface $node
     * @param InstructionInterface $graph
     *
     * @return InstructionInterface
     */
    private function addLabel(BtreeNodeInterface $node, InstructionInterface $graph): InstructionInterface
    {
        $keysIterator = iterable_array(array_values($node->getKeys()));
        $labelHolder = $this->labelHolderFactory->create([]);
        while ($key = $keysIterator->current()) {
            $isLeftEdge = !$keysIterator->offsetExists($keysIterator->key() - 1);
            $isRightEdge = !$keysIterator->offsetExists($keysIterator->key() + 1);

            $labelHolder->setKey($key);
            $labelHolder->isLeftEdge($isLeftEdge);
            $labelHolder->isRightEdge($isRightEdge);

            $this->labelAssemblerProcessor->assemble($labelHolder, $node, $graph);

            $keysIterator->next();
        }

        $graph->node(
            $node->getUuid(),
            ['shape' => 'record', 'height' => .1, 'label' => $labelHolder->getLabel()]
        );

        return $graph;
    }
}