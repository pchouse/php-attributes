<?php
declare(strict_types=1);

namespace PChouse\Attributes;

interface IBaseCache
{

    public function cacheKey(\ReflectionClass $reflectionClass): string;

    public function cacheFileName(\ReflectionClass $reflectionClass): string;

    public function cacheExist(\ReflectionClass $reflectionClass): bool;

    public function removeFromCache(\ReflectionClass $reflectionClass): void;

    /**
     * @return void
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function clearCache(): void;
}