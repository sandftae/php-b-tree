<?php

declare(strict_types=1);

namespace Play\Hard\Code\Dump;

use Play\Hard\Code\Btree\Api\BtreeNodeInterface;
use Play\Hard\Code\Utility\FileManager;

use function func\json_encode;

/**
 * @final DataDumper
 *
 * @package Play\Hard\Code\Dump
 */
final readonly class DataDumper implements DataDumperInterface
{
    /**
     * DataDumper constructor.
     *
     * @param FileManager $fileManager
     * @param string $dirName
     * @param string $fileName
     */
    public function __construct(
        private FileManager $fileManager,
        private string $dirName,
        private string $fileName
    ) {}

    /** @inheritDoc */
    public function dump(BtreeNodeInterface $node): void
    {
        $fileName = $this->fileName . '_' . date('Y-m-d-H:i:s');
        $nodesData = array_merge(['maxKeys' => $node->getCapacity(), 'keyType' => 'number'], ['nodeData' => $this->extractNodes($node)]);

        $this->fileManager->putContent($this->dirName, $fileName, json_encode($nodesData));
    }

    /**
     * Extract nodes recursively
     *
     * @param BtreeNodeInterface $node
     *
     * @return array
     */
    private function extractNodes(BtreeNodeInterface $node): array
    {
        $children = [];
        $result = ['name' => ['id' => $node->getUuid(), 'keys' => array_keys($node->getKeys())]];

        foreach ($node->getChildNodes() as $node) {
            $children[] = $this->extractNodes($node);
        }

        if (!empty($children)) {
            $result['children'] = $children;
        }

        return $result;

    }
}