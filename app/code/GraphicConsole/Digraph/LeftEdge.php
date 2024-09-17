<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Digraph;

use Play\Hard\Code\Btree\Model\Trait\MinMax;
use Play\Hard\Code\GraphicConsole\Digraph\Enum\GraphRecordCode;
use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Play\Hard\Code\GraphicConsole\Api\{
    LabelAssemblerProcessorInterface,
    LabelHolderInterface
};
use Graphviz\InstructionInterface;

/**
 * @final LeftEdge
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph
 */
final readonly class LeftEdge implements LabelAssemblerProcessorInterface
{
    use MinMax;

    /** @inheritDoc */
    public function assemble(LabelHolderInterface $labelHolder, BtreeNodeInterface $node, InstructionInterface $graph): LabelHolderInterface
    {
        if ($labelHolder->isLeftEdge()) {
            $singleKeyNode = count($node->getKeys()) === 1;
            $rKCode = GraphRecordCode::RIGHTMOST_KEY_NODE_CODE->value;
            $lKCode = GraphRecordCode::LEFTMOST_KEY_NODE_CODE->value;
            $lPCode = GraphRecordCode::LEFT_POINTER_CODE->value;

            $labelSubString = sprintf('<%s>|<%s>%s', $lPCode, $rKCode, $labelHolder->getKey()->getValue());

            if (!$singleKeyNode && !$labelHolder->isRightEdge()) {
                $labelSubString = sprintf('<%s>|<%s>%s', $lPCode, $lKCode, $labelHolder->getKey()->getValue());
            }

            if ($singleKeyNode && !$node->getParentNode()->isRoot()) {
                $maxParentValue = $this->getMaxVal($node->getParentNode()->getKeys());
                $isRightOffset = $maxParentValue < $labelHolder->getKey()->getValue();

                if($isRightOffset) {
                    $labelSubString = sprintf('<%s>|<%s>%s', $lPCode, $lKCode, $labelHolder->getKey()->getValue());
                }
            }

            if ($leftNode = $labelHolder->getKey()->getLeftNode()) {
                $graph->edge([
                    [$node->getUuid(), $lPCode],
                    [$leftNode->getUuid(), $rKCode],
                ]);
            }

            $labelHolder->addLabelSubString($labelSubString);
        }

        return $labelHolder;
    }
}