<?php

declare(strict_types=1);

namespace Play\Hard\Frame\Config;

/**
 * @interface DiConfigProviderInterface
 *
 * @package Play\Hard\Frame\Config
 */
interface DiConfigProviderInterface
{
    /**
     * Get a preferred child object for the specified type
     *
     * @param string $type
     *
     * @return string|null
     *
     * @throws \Exception
     */
    public function getInstantiation(string $type): ?string;

    /**
     * Get complex arguments predefined for the class given
     *
     * @param string $className
     * @param string $parameter
     *
     * @return mixed<array|string|null>
     *
     * @throws \Exception
     */
    public function getArgumentList(string $className, string $parameter): mixed;
}