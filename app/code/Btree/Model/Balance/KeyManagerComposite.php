<?php

declare(strict_types=1);

namespace Play\Hard\Code\Btree\Model\Balance;

use Play\Hard\Code\Btree\Api\{BtreeNodeKeyInterface, BtreeNodeInterface};

/**
 * @final KeyManagerComposite
 *
 * @package Play\Hard\Code\Btree\Model\Balance
 */
final readonly class KeyManagerComposite implements KeyManagerCompositeInterface
{
    /**
     * KeyNodePositionComposite construct
     *
     * @param array<KeyManagerCompositeInterface> $positionManagers
     */
    public function __construct(private array $positionManagers) {}

    /** @inheritDoc */
    public function doKeyPosition(BtreeNodeInterface $node, BtreeNodeKeyInterface $keyCandidate): BtreeNodeInterface
    {
        $nodeProcessed = null;

        foreach ($this->positionManagers as $positionManager) {
            $nodeProcessed = $positionManager->doKeyPosition($node, $keyCandidate);
        }

        return $nodeProcessed;
    }
}