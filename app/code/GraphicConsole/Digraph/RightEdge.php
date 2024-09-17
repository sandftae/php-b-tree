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
 * @final RightEdge
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph
 */
final readonly class RightEdge implements LabelAssemblerProcessorInterface
{
    /** @inheritDoc */
    public function assemble(
        LabelHolderInterface $labelHolder,
        BtreeNodeInterface $node,
        InstructionInterface $graph
    ): LabelHolderInterface {
        $singleKeyNode = count($node->getKeys()) === 1;
        if ($labelHolder->isRightEdge()) {
            $rKCode = GraphRecordCode::RIGHTMOST_KEY_NODE_CODE->value;
            $lKCode = GraphRecordCode::LEFTMOST_KEY_NODE_CODE->value;
            $rPCode = GraphRecordCode::RIGHT_POINTER_CODE->value;

            $labelSubString = sprintf('<%s>%s|<%s>', $rKCode, $labelHolder->getKey()->getValue(), $rPCode);

            if ($singleKeyNode) {
                $labelSubString = sprintf('|<%s>', $rPCode);
            }

            $labelHolder->addLabelSubString($labelSubString);

            if ($rightNode = $labelHolder->getKey()->getRightNode()) {
                $graph->edge([
                    [$node->getUuid(), $rPCode],
                    [$rightNode->getUuid(), $lKCode],
                ]);
            }
        }

        return $labelHolder;
    }
}