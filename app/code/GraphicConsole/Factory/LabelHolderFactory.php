<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Factory;

use Play\Hard\Code\GraphicConsole\Api\LabelHolderInterface;
use Play\Hard\Frame\Factory\Entity\EntityFactory;

/**
 * @final LabelHolderFactory
 *
 * @package Play\Hard\Code\GraphicConsole\Factory
 */
final readonly class LabelHolderFactory
{
    /**
     * LabelHolderFactory constructor.
     *
     * @param EntityFactory $entityFactory
     */
    public function __construct(private EntityFactory $entityFactory) {}

    /**
     * Create an instance of LabelHolderInterface
     *
     * @param array $arguments
     *
     * @return LabelHolderInterface
     */
    public function create(array $arguments): LabelHolderInterface
    {
        return $this->entityFactory->create(LabelHolderInterface::class, $arguments);
    }
}