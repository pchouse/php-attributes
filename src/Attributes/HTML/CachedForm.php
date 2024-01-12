<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

use PChouse\Attributes\AAttributes;
use PChouse\Attributes\Config\Config;
use PChouse\Attributes\HTML\Cache\CacheException;

class CachedForm extends AAttributes
{

    /**
     * The Reflection of the class where these options were attached
     *
     * @var \ReflectionClass|null
     */
    private \ReflectionClass|null $attachedReflectionClass = null;

    /**
     * @return \ReflectionClass|null
     */
    public function getAttachedReflectionClass(): ?\ReflectionClass
    {
        return $this->attachedReflectionClass;
    }

    /**
     * @param \ReflectionClass|null $attachedReflectionClass
     *
     * @return $this
     */
    public function setAttachedReflectionClass(?\ReflectionClass $attachedReflectionClass): static
    {
        $this->attachedReflectionClass = $attachedReflectionClass;
        return $this;
    }

    /**
     * @return array
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function toStackArray(): array
    {
        return Config::instance()->getHtmlCache()?->getFromCache(
            $this->getAttachedReflectionClass() ??
            throw new CacheException("Reflection attached class not defined")
        ) ?? throw new CacheException("The array not exist in cache");
    }
}
