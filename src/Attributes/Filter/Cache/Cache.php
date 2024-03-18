<?php
declare(strict_types=1);

namespace PChouse\Attributes\Filter\Cache;

use PChouse\Attributes\ABaseCache;

/**
 * Filesystem cache, best performance when using Opcache
 */
class Cache extends ABaseCache implements ICache
{

    protected static ICache|null $cache = null;

    protected function __construct()
    {
        parent::__construct(
            \sprintf(
                "%s%s%s",
                ATTRIBUTES_CACHE_DIR,
                DIRECTORY_SEPARATOR,
                "Filter"
            )
        );
    }

    /**
     * @return \PChouse\Attributes\Filter\Cache\ICache
     */
    public static function instance(): ICache
    {
        if (static::$cache === null) {
            static::$cache = new Cache();
        }
        return static::$cache;
    }


    /**
     * Get value from cache or null if not exists
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return string|null
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    #[\Override]
    public function getFromCache(\ReflectionClass $reflectionClass): string|null
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
     * @param string $string
     *
     * @return void
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     */
    #[\Override]
    public function putInCache(\ReflectionClass $reflectionClass, string $string): void
    {
        $arrayStringify = \var_export($string, true);

        $bytes = \file_put_contents(
            $this->cacheFileName($reflectionClass),
            \sprintf("<?php\r\n return %s;", $arrayStringify)
        );

        if ($bytes === false) {
            throw new FilterCacheException("Error write in cache");
        }
    }

}
