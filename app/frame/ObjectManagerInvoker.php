<?php

declare(strict_types=1);

namespace Play\Hard\Frame;

use Play\Hard\Frame\System\FileSystem;
use Play\Hard\Frame\ObjectManager\{
    ObjectManagerInterface,
    ObjectManager
};
use Play\Hard\Frame\Factory\{
    Resolver\ConstructorCompositeResolver,
    DynamicObjectFactory
};
use Play\Hard\Frame\Config\{
    Resolver\DiConfigCompositeResolver,
    DiConfigProvider
};

/**
 * @final ObjectManagerInvoker
 *
 * @package Play\Hard\Frame\ObjectManager
 */
final class ObjectManagerInvoker
{
    /** @var ObjectManagerInterface|null */
    private static ?ObjectManagerInterface $instance = null;

    /**
     * Get the instance of the Object Manager
     *
     * @return ObjectManagerInterface
     */
    public static function getInstance(): ObjectManagerInterface
    {
        if (!isset(self::$instance)) {
            self::$instance = self::configure();
        }

        return self::$instance;
    }

    /**
     * Configure Object Manager before use
     *
     * @return ObjectManagerInterface
     */
    private static function configure(): ObjectManagerInterface
    {
        return new ObjectManager(
            new DynamicObjectFactory(
                new ConstructorCompositeResolver,
                new DiConfigProvider(
                    new DiConfigCompositeResolver,
                    new FileSystem
                )
            )
        );
    }
}