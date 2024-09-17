<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Digraph;

use Play\Hard\Code\GraphicConsole\Digraph\Enum\GraphRecordCode;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Play\Hard\Code\GraphicConsole\Api\{
    LabelAssemblerProcessorInterface,
    LabelHolderInterface
};
use Graphviz\InstructionInterface;

/**
 * @final BetweenEdge
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph
 */
final readonly class BetweenEdge implements LabelAssemblerProcessorInterface
{
    /** @inheritDoc */
    public function assemble(
        LabelHolderInterface $labelHolder,
        BtreeNodeInterface $node,
        InstructionInterface $graph
    ): LabelHolderInterface {
        if (!$labelHolder->isRightEdge()) {
            $btwnPointer = GraphRecordCode::BETWEEN_POINTER_CODE->value . uniqid();
            $labelSubString = sprintf('|<%s>|', $btwnPointer);
            $isMultiBtwnState = count($node->getKeys()) > 2;

            if ($isMultiBtwnState && !$labelHolder->isLeftEdge()) {
                $labelSubString = sprintf('%s|<%s>|', $labelHolder->getKey()->getValue(), $btwnPointer);
            }

            $labelHolder->addLabelSubString($labelSubString);

            if ($rightNode = $labelHolder->getKey()->getRightNode()) {
                $graph->edge([
                    [$node->getUuid(), $btwnPointer],
                    [$rightNode->getUuid()]
                ]);
            }
        }

        return $labelHolder;
    }
}