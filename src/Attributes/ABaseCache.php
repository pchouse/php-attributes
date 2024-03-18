<?php
declare(strict_types=1);

namespace PChouse\Attributes;

use PChouse\Attributes\Filter\Cache\FilterCacheException;

abstract class ABaseCache implements IBaseCache
{
    protected string $cacheDirPath;

    /**
     * @param string $cacheDirPath
     *
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    public function __construct(string $cacheDirPath)
    {
        if (false === $cacheDirPath = \realpath($cacheDirPath)) {
            throw new FilterCacheException(\sprintf("Path %s is not valid", $cacheDirPath));
        }

        $this->cacheDirPath = $cacheDirPath;

        if (!\is_dir($this->cacheDirPath)) {
            throw new FilterCacheException(\sprintf("Path %s is not a directory", $this->cacheDirPath));
        }
    }


    /**
     * The cache key, base for file cache name
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    #[\Override]
    public function cacheKey(\ReflectionClass $reflectionClass): string
    {
        if (false === $path = $reflectionClass->getFileName()) {
            throw new FilterCacheException("Class does not exist in filesystem");
        }

        if (false === $md5 = \md5_file($path)) {
            throw new FilterCacheException("Error getting md5 of class file");
        }

        return $md5;
    }

    /**
     * The cache file name, full path
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    #[\Override]
    public function cacheFileName(\ReflectionClass $reflectionClass): string
    {
        return \sprintf(
            "%s%s%s.php",
            $this->cacheDirPath,
            DIRECTORY_SEPARATOR,
            $this->cacheKey($reflectionClass)
        );
    }

    /**
     * Check if cache exists
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return bool
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    #[\Override]
    public function cacheExist(\ReflectionClass $reflectionClass): bool
    {
        return \file_exists($this->cacheFileName($reflectionClass));
    }

    /**
     * Remove from cache
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return void
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    public function removeFromCache(\ReflectionClass $reflectionClass): void
    {
        $cacheFileName = $this->cacheFileName($reflectionClass);
        if (\file_exists($cacheFileName)) {
            \unlink($cacheFileName);
        }
    }

    /**
     * @return void
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    #[\Override]
    public function clearCache(): void
    {
        if (false === $scanDir = \scandir($this->cacheDirPath)) {
            throw new FilterCacheException("Error scanning cache directory");
        }

        foreach ($scanDir as $fileName) {
            if (\str_ends_with($fileName, ".php")) {
                \unlink($this->cacheDirPath . DIRECTORY_SEPARATOR . $fileName);
            }
        }
    }

}