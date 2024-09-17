<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Cli;

use Play\Hard\Code\GraphicConsole\Api\GraphicConsoleManagerInterface;
use Play\Hard\Frame\Cli\Spi\ArgumentProviderInterface;
use Play\Hard\Frame\Factory\Entity\EntityFactory;
use Play\Hard\Code\Dump\DataDumperInterface;
use Play\Hard\Code\Btree\Api\{
    BTreeStructureInterface,
    BtreeNodeKeyInterface,
    BtreeNodeInterface
};
use Uuid\Uuid;

/**
 * @final BtreeProcessor
 *
 * @package Play\Hard\Code\Btree\Cli
 */
final readonly class BtreeProcessor implements BtreeProcessorInterface
{
    /**
     * BtreeProcessor constructor.
     *
     * @param GraphicConsoleManagerInterface $graphicConsole
     * @param DataDumperInterface $dataDumper
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        private GraphicConsoleManagerInterface $graphicConsole,
        private DataDumperInterface $dataDumper,
        private EntityFactory $entityFactory
    ) {}

    /** @inheritDoc */
    public function run(ArgumentProviderInterface $argumentProvider): void
    {
        $rootNodeWrapper = $this->entityFactory->create(
            BtreeNodeInterface::class,
            [
                'isRoot' => true,
                'childNodes' => [],
                'nodeKeys' => [],
                'capacity' => $argumentProvider->capacity(),
                'uuid' => Uuid::generate()
            ]
        );

        /** @var BTreeStructureInterface $tree */
        $tree = $this->entityFactory->create(BTreeStructureInterface::class, ['treeNode' => $rootNodeWrapper->getPureNode()]);

        foreach (array_unique($argumentProvider->numSet()) as $value) {
            /** @var BtreeNodeKeyInterface $key */
            $key = $this->entityFactory->create(BtreeNodeKeyInterface::class, ['keyValue' => (int)$value]);

            $tree->addCandidate($key)->doBalancing();
        }

        if ($argumentProvider->graphDumpRequested()) {
            $this->dataDumper->dump($tree->getTreeNode());
        }

        if ($argumentProvider->graphImageRequested()) {
            $this->graphicConsole->draw($tree->getTreeNode());
        }
    }
}