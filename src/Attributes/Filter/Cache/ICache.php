<?php
declare(strict_types=1);

namespace PChouse\Attributes\Filter\Cache;

use PChouse\Attributes\IBaseCache;

/**
 * Filesystem cache, best performance when using Opcache
 */
interface ICache extends IBaseCache
{
    public function getFromCache(\ReflectionClass $reflectionClass): string|null;

    /**
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function putInCache(\ReflectionClass $reflectionClass, string $string): void;

}
