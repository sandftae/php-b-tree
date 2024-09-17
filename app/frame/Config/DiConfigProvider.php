<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config;

use Play\Hard\Frame\Config\Resolver\{
    DiConfigCompositeResolver,
    ArgumentListResolver,
    ImplementResolver
};
use Play\Hard\Frame\System\FileSystem;
use Kiwilan\XmlReader\XmlReader;

/**
 * @final ConfigProvider
 *
 * @package Play\Hard\Frame\Config
 */
final class DiConfigProvider implements DiConfigProviderInterface
{
    /** @var array */
    private static array $diConfiguration;

    /**
     * DiConfigProvider constructor.
     *
     * @param DiConfigCompositeResolver $compositeLoader
     * @param FileSystem $fileSystem
     */
    public function __construct(
        private readonly DiConfigCompositeResolver $compositeLoader,
        private readonly FileSystem $fileSystem,
    ) {}

    /** @inheritDoc */
    public function getInstantiation(string $type): ?string
    {
        $type = $type ? ltrim($type, '\\') : '';

        if (!isset(self::$diConfiguration)) {
            self::$diConfiguration = $this->loadConfiguration();
        }

        return self::$diConfiguration[ImplementResolver::IMPLEMENTATION_ARG_LEAF_NAME][$type] ?? null;
    }

    /** @inheritDoc */
    public function getArgumentList(string $className, string $parameter): mixed
    {
        $value = [];
        if (!isset(self::$diConfiguration)) {
            self::$diConfiguration = $this->loadConfiguration();
        }

        if(isset(self::$diConfiguration[ArgumentListResolver::ARG_LIST_LEAF_NAME][$className][$parameter])) {
            $value = self::$diConfiguration[ArgumentListResolver::ARG_LIST_LEAF_NAME][$className][$parameter];
        }

        return $value;
    }

    /**
     * Extract dependency injection configuration
     *
     * @return array
     *
     * @throws \Exception
     */
    public function loadConfiguration(): array
    {
        $diFolder =$this->fileSystem->getFolderPath('app/container');
        $diConfigurationXmlPath = $diFolder . DIRECTORY_SEPARATOR . 'di.xml';

        $rows = XmlReader::make($diConfigurationXmlPath)->getContents()?: [];

        return $this->compositeLoader->resolve($rows);
    }
}