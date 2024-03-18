<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML\Cache;

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
                "HTML"
            )
        );
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
     * Get value from cache or null if not exists
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return array|null
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
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
     * @throws \PChouse\Attributes\Filter\Cache\FilterCacheException
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function putInCache(\ReflectionClass $reflectionClass, array $array): void
    {
        $arrayStringify = \var_export($array, true);

        $bytes = \file_put_contents(
            $this->cacheFileName($reflectionClass),
            \sprintf("<?php\r\n return %s;", $arrayStringify)
        );

        if ($bytes === false) {
            throw new HtmlCacheException("Error write in cache");
        }
    }

}
