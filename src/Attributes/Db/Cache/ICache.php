<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db\Cache;

use PChouse\Attributes\IBaseCache;

/**
 * Filesystem cache, best performance when using Opcache
 */
interface ICache extends IBaseCache
{
    public function cacheKey(\ReflectionClass $reflectionClass): string;


    public function cacheExist(\ReflectionClass $reflectionClass): bool;


    public function getFromCache(\ReflectionClass $reflectionClass): string|null;

    /**
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function putInCache(\ReflectionClass $reflectionClass, string $string): void;

    /**
     * @return void
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function clearCache(): void;
}
