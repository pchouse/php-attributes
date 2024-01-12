<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML\Cache;

/**
 * Filesystem cache, best performance when using Opcache
 */
class Cache implements ICache
{

    protected static ICache|null $cache = null;

    protected function __construct()
    {
    }

    /**
     * @return \PChouse\Attributes\HTML\Cache\ICache
     */
    public static function instance(): ICache
    {
        if (static::$cache === null) {
            static::$cache = new Cache();
        }
        return static::$cache;
    }

    /**
     * The cache key, base for file cache name
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function cacheKey(\ReflectionClass $reflectionClass): string
    {
        if (false === $path = $reflectionClass->getFileName()) {
            throw new CacheException("Class does not exist in filesystem");
        }

        if (false === $md5 = \md5_file($path)) {
            throw new CacheException("Error getting md5 of class file");
        }

        return $md5;
    }

    /**
     * The cache file name, full path
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function cacheFileName(\ReflectionClass $reflectionClass): string
    {
        return \sprintf(
            "%s%s%s%s%s.php",
            ATTRIBUTES_CACHE_DIR,
            DIRECTORY_SEPARATOR,
            "HTML",
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
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
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
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function removeFromCache(\ReflectionClass $reflectionClass): void
    {
        $cacheFileName = $this->cacheFileName($reflectionClass);
        if (\file_exists($cacheFileName)) {
            \unlink($cacheFileName);
        }
    }

    /**
     * Get value from cache or null if not exists
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return array|null
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function getFromCache(\ReflectionClass $reflectionClass): array|null
    {
        if (!$this->cacheExist($reflectionClass)) {
            return null;
        }

        return include $this->cacheFileName($reflectionClass);
    }

    /**
     * Put array in cache
     *
     * @param \ReflectionClass $reflectionClass
     * @param array $array
     *
     * @return void
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function putInCache(\ReflectionClass $reflectionClass, array $array): void
    {
        $arrayStringify = \var_export($array, true);

        $bytes = \file_put_contents(
            $this->cacheFileName($reflectionClass),
            \sprintf("<?php\r\n return %s;", $arrayStringify)
        );

        if ($bytes === false) {
            throw new CacheException("Error write in cache");
        }
    }

    /**
     * @return void
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function clearCache(): void
    {
        $directory = ATTRIBUTES_CACHE_DIR . DIRECTORY_SEPARATOR . "HTML";

        if (false === $scanDir = \scandir($directory)) {
            throw new CacheException("Error scanning cache directory");
        }

        foreach ($scanDir as $fileName) {
            if (\str_ends_with($fileName, ".php")) {
                \unlink($directory . DIRECTORY_SEPARATOR . $fileName);
            }
        }
    }
}
