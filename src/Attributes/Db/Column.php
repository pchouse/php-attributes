<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace PChouse\Attributes\Db;

use PChouse\Attributes\AttributesException;
use PChouse\Attributes\Config\Config;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Column
{

    /**
     * Defines if the column accepts null values
     *
     * @var bool|null $allowNull
     */
    private ?bool $allowNull = null;

    /**
     * The PHP property PHP type
     *
     * @var string|null
     */
    private ?string $propertyType = null;

    /**
     * The instance property name
     *
     * @var string|null
     */
    private ?string $propertyName = null;

    /**
     * @param string|null $name                       The database column name
     * @param \PChouse\Attributes\Db\Types|null $type The database column type
     * @param int|null $maximumLength                 The database maximum column length or decimal precision
     * @param int|null $minimumLength                 The database minimum column length
     * @param int|float|null $maximum                 The maximum numeric value
     * @param int|float|null $minimum                 The minimum numeric value
     * @param int|null $decimalPrecision              The database column decimal precision
     * @param int|null $decimalScale                  The database column decimal scale
     * @param string|null $regExp                     A RegExp to validate the values
     * @param bool $isPrimaryKey
     *
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function __construct(
        private ?string        $name = null,
        private ?Types         $type = null,
        private ?int           $maximumLength = null,
        private ?int           $minimumLength = null,
        private null|int|float $maximum = null,
        private null|int|float $minimum = null,
        private ?int           $decimalPrecision = null,
        private ?int           $decimalScale = null,
        private ?string        $regExp = null,
        private bool           $isPrimaryKey = false,
    ) {
        $this->verifyLengths();
        $this->verifyDecimalScale();
        $this->verifyDecimalPrecision();
    }

    /**
     * Verify maximum length and minimum length
     *
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    protected function verifyLengths(): void
    {
        if ($this->maximumLength !== null && $this->maximumLength <= 0) {
            throw new MaximumLengthException(
                "maximum length cannot be negative or zero"
            );
        }

        if ($this->minimumLength !== null && $this->minimumLength < 0) {
            throw new MinimumLengthException(
                "minimum length cannot be negative"
            );
        }

        if ($this->maximumLength !== null &&
            $this->minimumLength !== null &&
            $this->maximumLength < $this->minimumLength
        ) {
            throw new MaximumLengthException(
                "maximum cannot be less than minimum"
            );
        }
    }

    /**
     * Validate decimal scale
     *
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    protected function verifyDecimalScale(): void
    {
        if ($this->decimalScale !== null && $this->decimalScale < 0) {
            throw new DecimalScaleException(
                "decimal scale cannot be less than zero"
            );
        }
    }

    /**
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    protected function verifyDecimalPrecision(): void
    {
        if ($this->decimalPrecision !== null && $this->decimalPrecision < 1) {
            throw new DecimalPrecisionException(
                "decimal precision cannot be less than one"
            );
        }
    }


    /**
     * Gets if column accepts null value
     *
     * @return bool|null The value of allow null value. Can be either a boolean value or null.
     */
    public function getAllowNull(): ?bool
    {
        return $this->allowNull;
    }

    /**
     * Set whether the column allows null values.
     *
     * @param bool|null $allowNull Determines if null values are allowed for the column.
     *                             Use true to allow null, false to disallow null,
     *                             or null to inherit from the table's default behavior.
     *
     * @return $this Returns the current instance of the Column class.
     */
    public function setAllowNull(?bool $allowNull): Column
    {
        $this->allowNull = $allowNull;
        return $this;
    }

    /**
     * Retrieves the property PHP type.
     *
     * @return string|null The property type, or null if not set.
     */
    public function getPropertyType(): ?string
    {
        return $this->propertyType;
    }

    /**
     * Sets the property PHP type for the column.
     *
     * @param string|null $propertyType The type of the property associated with the column. Can be null.
     *
     * @return $this
     */
    public function setPropertyType(?string $propertyType): Column
    {
        $this->propertyType = $propertyType;
        return $this;
    }

    /**
     * Retrieves the property name.
     *
     * @return string|null The name of the property, or null if it is not set.
     */
    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    /**
     * Sets the propertyName.
     *
     * @param string $propertyName The propertyName value to set, or null to unset.
     *
     * @return Column The Column object.
     */
    public function setPropertyName(string $propertyName): Column
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * Retrieves the database column name.
     *
     * @return string|null The database column name or null if not set.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the database column name
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the database column type.
     *
     * @return \PChouse\Attributes\Db\Types|null The database column type
     */
    public function getType(): ?Types
    {
        return $this->type;
    }

    /**
     * Set the database column datatype
     *
     * @param \PChouse\Attributes\Db\Types $type
     *
     * @return \PChouse\Attributes\Db\Column
     */
    public function setType(Types $type): Column
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the maximum length of the column.
     *
     * @return int|null The maximum length of the column or null if not set.
     */
    public function getMaximumLength(): ?int
    {
        return $this->maximumLength;
    }

    /**
     * @param int $maximumLength
     *
     * @return $this
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function setMaximumLength(int $maximumLength): Column
    {
        $this->maximumLength = $maximumLength;
        $this->verifyLengths();
        return $this;
    }

    /**
     * Returns the minimum length of the database column.
     *
     * @return int|null The minimum length of the database column, or null if not set.
     */
    public function getMinimumLength(): ?int
    {
        return $this->minimumLength;
    }

    /**
     * @param int $minimumLength
     *
     * @return $this
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function setMinimumLength(int $minimumLength): Column
    {
        $this->minimumLength = $minimumLength;
        $this->verifyLengths();
        return $this;
    }

    /**
     * Get the database maximum decimal precision
     *
     * @return int|null
     */
    public function getDecimalPrecision(): ?int
    {
        return $this->decimalPrecision;
    }

    /**
     * Set the database maximum decimal precision
     *
     * @param int|null $decimalPrecision
     *
     * @return $this
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function setDecimalPrecision(?int $decimalPrecision): Column
    {
        $this->decimalPrecision = $decimalPrecision;
        $this->verifyDecimalPrecision();
        return $this;
    }


    /**
     * Returns the decimal scale.
     *
     * @return int|null The decimal scale value if set, otherwise null.
     */
    public function getDecimalScale(): ?int
    {
        return $this->decimalScale;
    }

    /**
     * Sets the decimal scale for the column.
     *
     * @param int $decimalScale The decimal scale value to set. A null value signifies no decimal scale is specified.
     *
     * @return Column The Column object with the updated decimal scale value.
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function setDecimalScale(int $decimalScale): Column
    {
        $this->decimalScale = $decimalScale;
        $this->verifyDecimalScale();
        return $this;
    }

    /**
     * Set a regexp to validate strings
     *
     * @param string|null $regExp
     *
     * @return void
     */
    public function setRegExp(?string $regExp): void
    {
        $this->regExp = $regExp;
    }

    /** Get the RegExp to validate the field value, or null if not have
     *
     * @return string|null
     */
    public function getRegExp(): ?string
    {
        return $this->regExp;
    }

    /**
     * Set if teh column is the table primary key
     *
     * @param bool $isPrimaryKey
     *
     * @return \PChouse\Attributes\Db\Column
     */
    public function setIsPrimaryKey(bool $isPrimaryKey): Column
    {
        $this->isPrimaryKey = $isPrimaryKey;
        return $this;
    }

    /**
     * Get if teh column is the table primary key
     *
     * @return bool
     */
    public function getIsPrimaryKey(): bool
    {
        return $this->isPrimaryKey;
    }

    /**
     * Get the numeric maximum value
     *
     * @return float|int|null
     */
    public function getMaximum(): float|int|null
    {
        return $this->maximum;
    }

    /**
     * Get the minimum numeric value
     *
     * @return float|int|null
     */
    public function getMinimum(): float|int|null
    {
        return $this->minimum;
    }

    /**
     * Set the maximum value for numeric
     *
     * @param float|int|null $maximum
     *
     * @return $this
     */
    public function setMaximum(float|int|null $maximum): Column
    {
        $this->maximum = $maximum;
        return $this;
    }

    /**
     * Set the minimum value for numeric
     *
     * @param float|int|null $minimum
     *
     * @return $this
     */
    public function setMinimum(float|int|null $minimum): Column
    {
        $this->minimum = $minimum;
        return $this;
    }

    /**
     * Parse column
     *
     * @param \ReflectionClass $attachedReflectionClass
     * @param \PChouse\Attributes\Db\ITypeMap|null $typeMap
     *
     * @return array<string, \PChouse\Attributes\Db\Column>
     * @throws \PChouse\Attributes\AttributesException
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public static function parse(\ReflectionClass $attachedReflectionClass, ?ITypeMap $typeMap): array
    {
        if (Config::instance()->getDbCache()?->cacheExist($attachedReflectionClass) === true) {
            if (null === $serialized = Config::instance()->getDbCache()->getFromCache($attachedReflectionClass)) {
                throw new AttributesException("Error fetching Columns from cache");
            }
            return \unserialize($serialized);
        }

        $columns = [];

        $properties = $attachedReflectionClass->getProperties();

        foreach ($properties as $property) {
            $attributes = $property->getAttributes(Column::class);

            if (\count($attributes) === 0) {
                continue;
            }

            /** @var \PChouse\Attributes\Db\Column $column */
            $column = $attributes[0]->newInstance();

            if ($column->getName() === null) {
                $column->setName($property->getName());
            }

            $column->setPropertyName($property->getName());

            $columns[$column->getName()] = $column;

            if (null === $propertyType = $property->getType()) {
                continue;
            }

            if (!($propertyType instanceof \ReflectionNamedType)) {
                continue;
            }

            if ($column->allowNull === null) {
                $column->setAllowNull($propertyType->allowsNull());
            }

            if ($column->getType() === null) {
                if (null !== $type = $typeMap?->dbTypeFor($propertyType->getName())) {
                    $column->setType($type);
                }
            }
        }

        $serialized = \serialize($columns);

        Config::instance()->getDbCache()?->putInCache($attachedReflectionClass, $serialized);

        return $columns;
    }

    /**
     * @param object|string|bool|int|float|null $value The value to validate or the class instance witch the value will
     *                                                 be got from reflection
     *
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function validate(object|string|bool|int|float|null $value): void
    {
        if (\is_object($value)) {
            $reflection = new \ReflectionClass($value);
            try {
                $property = $reflection->getProperty($this->propertyName ?? "");
            } catch (\ReflectionException) {
                throw new ColumnValidateException(
                    \sprintf(
                        "Property %s not exist in class %s",
                        $this->propertyName ?? "Not defined",
                        $reflection->getName()
                    ),
                    ColumnValidateException::PROPERTY_NAME_NOT_EXIST
                );
            }
            /** @noinspection all */
            $property->setAccessible(true);
            $rawValue = $property->getValue($value);
        } else {
            $rawValue = $value;
        }

        if ($rawValue !== null && !\is_string($rawValue) && !\is_numeric($rawValue) && !\is_bool($rawValue)) {
            throw new ColumnValidateException(
                "Value to validate must be of type string|bool|int|float",
                ColumnValidateException::VALUE_TYPE_NOT_VALID
            );
        }

        if ($rawValue === null) {
            if (!$this->getAllowNull()) {
                throw new ColumnValidateException(
                    \sprintf("Null is not allowed for column %s", $this->getName()),
                    ColumnValidateException::NULL_NOT_ALLOWED
                );
            }
            return;
        }

        if (\is_string($rawValue)) {
            if ($this->getMaximumLength() !== null && \strlen($rawValue) > $this->getMaximumLength()) {
                throw new ColumnValidateException(
                    \sprintf(
                        "Column %s maximum length is %s but has %s",
                        $this->getName(),
                        $this->getMaximumLength(),
                        \strlen($rawValue)
                    ),
                    ColumnValidateException::EXCEEDS_MAXIMUM_LENGTH
                );
            }

            if ($this->getMinimumLength() !== null && \strlen($rawValue) < $this->getMinimumLength()) {
                throw new ColumnValidateException(
                    \sprintf(
                        "Column %s minimum length is %s but has %s",
                        $this->getName(),
                        $this->getMinimumLength(),
                        \strlen($rawValue)
                    ),
                    ColumnValidateException::LESS_THAN_MINIMUM_LENGTH
                );
            }

            if ($this->getRegExp() !== null) {
                if (\preg_match($this->getRegExp(), $rawValue) !== 1) {
                    throw new ColumnValidateException(
                        \sprintf(
                            "Column %s fail regexp",
                            $this->getName(),
                        ),
                        ColumnValidateException::FAIL_REGEXP
                    );
                }
            }

            return;
        }

        if (\is_numeric($rawValue)) {
            if ($this->getMaximum() !== null && $rawValue > $this->getMaximum()) {
                throw new ColumnValidateException(
                    \sprintf(
                        "Column %s maximum is %s but has %s",
                        $this->getName(),
                        $this->getMaximum(),
                        $rawValue
                    ),
                    ColumnValidateException::VALUE_GRATER_THAN
                );
            }

            if ($this->getMinimum() !== null && $rawValue < $this->getMinimum()) {
                throw new ColumnValidateException(
                    \sprintf(
                        "Column %s minimum is %s but has %s",
                        $this->getName(),
                        $this->getMinimum(),
                        $rawValue
                    ),
                    ColumnValidateException::VALUE_LESS_THAN
                );
            }

            if ($this->getDecimalPrecision() !== null) {
                if (\strlen(\str_replace(".", "", (string)$rawValue)) > $this->getDecimalPrecision()) {
                    throw new ColumnValidateException(
                        \sprintf(
                            "Column %s exceeds maximum decimal precision",
                            $this->getName(),
                        ),
                        ColumnValidateException::EXCEEDS_MAXIMUM_PRECISION
                    );
                }
            }

            if ($this->getDecimalScale() !== null) {
                $decimalParts = \explode(".", (string)$rawValue);
                if (\count($decimalParts) < 2) {
                    return;
                }

                if (\strlen($decimalParts[1]) > $this->getDecimalScale()) {
                    throw new ColumnValidateException(
                        \sprintf(
                            "Column %s exceeds maximum decimal scale",
                            $this->getName(),
                        ),
                        ColumnValidateException::EXCEEDS_MAXIMUM_SCALE
                    );
                }
            }
        }
    }
}
