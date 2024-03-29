<?php
declare(strict_types=1);

namespace PChouse\Attributes\Config;

use PChouse\Attributes\HTML\Cache\Cache as HtmlCache;
use PChouse\Attributes\HTML\Cache\ICache as HtmlICache;
use PChouse\Attributes\Db\Cache\Cache as DbCache;
use PChouse\Attributes\Db\Cache\ICache as DbICache;
use PChouse\Attributes\Filter\Cache\ICache as FilterICache;
use PChouse\Attributes\Filter\Cache\Cache as FilterCache;

class Config
{

    protected static Config|null $config = null;

    protected HtmlICache|null $htmlCache = null;

    protected DbICache|null     $dbICache     = null;
    protected FilterICache|null $filterICache = null;

    protected function __construct()
    {
    }

    public static function instance(): Config
    {
        if (static::$config === null) {
            static::$config = new Config();
            static::$config->setHtmlCache(HtmlCache::instance());
            static::$config->setDbCache(DbCache::instance());
            static::$config->setFilterCache(FilterCache::instance());
        }
        return static::$config;
    }

    /**
     * @return \PChouse\Attributes\HTML\Cache\ICache|null
     */
    public function getHtmlCache(): ?HtmlICache
    {
        return $this->htmlCache;
    }

    /**
     * @param \PChouse\Attributes\HTML\Cache\ICache|null $htmlCache
     *
     * @return Config
     */
    public function setHtmlCache(?HtmlICache $htmlCache): Config
    {
        $this->htmlCache = $htmlCache;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\Db\Cache\ICache|null
     */
    public function getDbCache(): ?DbICache
    {
        return $this->dbICache;
    }

    /**
     * @param \PChouse\Attributes\Db\Cache\ICache|null $dbICache
     *
     * @return Config
     */
    public function setDbCache(?DbICache $dbICache): Config
    {
        $this->dbICache = $dbICache;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\Filter\Cache\ICache|null
     */
    public function getFilterCache(): ?FilterICache
    {
        return $this->filterICache;
    }

    /**
     * @param \PChouse\Attributes\Filter\Cache\ICache|null $filterICache
     *
     * @return Config
     */
    public function setFilterCache(?FilterICache $filterICache): Config
    {
        $this->filterICache = $filterICache;
        return $this;
    }
}
