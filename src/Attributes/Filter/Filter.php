<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace PChouse\Attributes\Filter;

use PChouse\Attributes\AttributesException;
use PChouse\Attributes\Config\Config;

/**
 * @template T
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS)]
class Filter
{

    /**
     * @param int[] $filterId    The multiple filter IDs that will be applied by order https://www.php.net/manual/en/filter.filters.php
     * @param array|int $options The filter options https://www.php.net/manual/en/filter.constants.php
     * @param bool $trim         Trim the value
     * @param string|null $name  The class property which the property apply
     */
    public function __construct(
        protected array     $filterId,
        protected array|int $options = 0,
        protected bool      $trim = true,
        protected ?string   $name = null,
    )
    {
        $this->setOptions($this->options);
    }

    /**
     * Filter the value
     *
     * @param string|int|float|bool $value The value to filter
     *
     * @return string|int|float|bool|null The filtered value
     * @throws \Exception
     */
    public function filter(string|int|float|bool|null $value): string|int|float|bool|null
    {
        if ($value === null || \is_bool($value)) {
            return $value;
        }

        if ($this->trim && \is_string($value)) {
            $value = \trim($value);
        }

        foreach ($this->getFilterId() as $filterId) {
            if (null === $value = \filter_var($value, $filterId, $this->options)) {
                throw new FilterException("filter failed");
            }
        }

        return $value;
    }

    /**
     * Parse all Filter attributes
     *
     * @param \ReflectionClass $attachedReflectionClass
     *
     * @return \PChouse\Attributes\Filter\Filter[]
     * @throws \PChouse\Attributes\AttributesException
     * @throws \PChouse\Attributes\Filter\FilterException
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public static function parse(\ReflectionClass $attachedReflectionClass): array
    {

        if (Config::instance()->getDbCache()?->cacheExist($attachedReflectionClass) === true) {
            if (null === $serialized = Config::instance()->getFilterCache()?->getFromCache($attachedReflectionClass)) {
                throw new AttributesException("Error fetching Columns from cache");
            }
            return \unserialize($serialized);
        }

        $existentFilterIds = \array_map(function ($filterName) {
            return \filter_id($filterName);
        }, \filter_list());

        $filters = [];

        $classAttributes = $attachedReflectionClass->getAttributes(Filter::class);

        foreach ($classAttributes as $filterAttribute) {

            /** @var \PChouse\Attributes\Filter\Filter $filter */
            $filter = $filterAttribute->newInstance();

            foreach ($filter->getFilterId() as $filterId) {
                if (!\in_array($filterId, $existentFilterIds)) {
                    throw new FilterException(
                        \sprintf("Filter ID %s not exist", $filterId)
                    );
                }
            }

            if ($filter->name === null || \trim($filter->name) === "") {
                throw new FilterException("Filters apply to class name cannot be empty");
            }

            if (\array_key_exists($filter->name, $filters)) {
                throw new FilterException(
                    "Cannot apply more than one filter to each property, so name must be uniq among the class properties"
                );
            }

            $filters[$filter->name] = $filter;
        }

        foreach ($attachedReflectionClass->getProperties() as $property) {

            $propertyAttributes = $property->getAttributes(Filter::class);

            if (\count($propertyAttributes) === 0) {
                continue;
            }

            /** @var \PChouse\Attributes\Filter\Filter $filter */
            $filter = $propertyAttributes[0]->newInstance();

            if ($filter->name === null || \trim($filter->name) === "") {
                $filter->name = $property->getName();
            }

            if (\array_key_exists($filter->name, $filters)) {
                throw new FilterException(
                    "Cannot apply more than one filter to each property, so name must be uniq among the class properties"
                );
            }

            $filters[$filter->name] = $filter;

        }

        $serialized = \serialize($filters);

        Config::instance()->getFilterCache()?->putInCache($attachedReflectionClass, $serialized);

        return $filters;

    }

    /**
     * @return int[]
     */
    public function getFilterId(): array
    {
        return $this->filterId;
    }

    /**
     * @param int[] $filterId
     *
     * @return Filter
     */
    public function setFilterId(array $filterId): Filter
    {
        $this->filterId = $filterId;
        return $this;
    }

    /**
     * @return array|int
     */
    public function getOptions(): array|int
    {
        return $this->options;
    }

    /**
     * @param array|int $options
     *
     * @return Filter
     */
    public function setOptions(array|int $options): Filter
    {
        if (\is_int($options)) {
            $this->options = $options | FILTER_NULL_ON_FAILURE;
        } else {
            ($options["flags"] ?? null) === null ?
                $options["flags"] = FILTER_NULL_ON_FAILURE :
                $options["flags"] |= FILTER_NULL_ON_FAILURE;
            $this->options = $options;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getTrim(): bool
    {
        return $this->trim;
    }

    /**
     * @param bool $trim
     *
     * @return Filter
     */
    public function setTrim(bool $trim): Filter
    {
        $this->trim = $trim;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return Filter
     */
    public function setName(?string $name): Filter
    {
        $this->name = $name;
        return $this;
    }

}