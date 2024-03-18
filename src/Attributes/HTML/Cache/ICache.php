<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML\Cache;

use PChouse\Attributes\IBaseCache;

/**
 * Filesystem cache, best performance when using Opcache
 */
interface ICache extends IBaseCache
{
    public function getFromCache(\ReflectionClass $reflectionClass): array|null;

    /**
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function putInCache(\ReflectionClass $reflectionClass, array $array): void;

}
