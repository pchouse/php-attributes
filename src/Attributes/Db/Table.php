<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace PChouse\Attributes\Db;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Table
{

    /**
     * @param string|null $name
     * @param bool $isView
     */
    public function __construct(
        private ?string $name = null,
        private bool    $isView = false,
    ) {
    }

    /**
     * Get the Table/View name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Determine if is a view
     *
     * @return bool
     */
    public function getIsView(): bool
    {
        return $this->isView;
    }

    public function setName(?string $name): Table
    {
        $this->name = $name;
        return $this;
    }

    public function setIsView(bool $isView): Table
    {
        $this->isView = $isView;
        return $this;
    }

    /**
     * Parse Table attribute
     *
     * @param \ReflectionClass $attachedReflectionClass
     *
     * @return \PChouse\Attributes\Db\Table
     * @throws \PChouse\Attributes\Db\TableAttributeException
     */
    public static function parse(\ReflectionClass $attachedReflectionClass): Table
    {
        $attributes = $attachedReflectionClass->getAttributes(Table::class);

        if (\count($attributes) === 0) {
            throw new TableAttributeException("No attribute found");
        }

        /** @var \PChouse\Attributes\Db\Table $table */
        $table = $attributes[0]->newInstance();

        if ($table->getName() === null) {
            $table->setName(
                $attachedReflectionClass->getShortName()
            );
        }

        return $table;
    }
}
