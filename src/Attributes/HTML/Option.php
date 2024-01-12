<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

use JetBrains\PhpStorm\ArrayShape;
use PChouse\Attributes\AAttributes;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Option extends AAttributes implements \Stringable
{
    /**
     * @param string $value
     * @param string $text
     * @param bool $selected
     */
    public function __construct(
        private string $value = "",
        private string $text = "",
        private bool   $selected = false
    ) {
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return Option
     */
    public function setValue(string $value): Option
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Option
     */
    public function setText(string $text): Option
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSelected(): bool
    {
        return $this->selected;
    }

    /**
     * @param bool $selected
     *
     * @return Option
     */
    public function setIsSelected(bool $selected): Option
    {
        $this->selected = $selected;
        return $this;
    }

    /**
     * @return array
     */
    #[ArrayShape([
        "value" => "string", "text" => "string", "selected" => "bool"
    ])]
    public function toArray(): array
    {
        $array          = [];
        $array["value"] = $this->value;
        $array["text"]  = $this->getTranslator()?->translate($this->text) ?? $this->text;
        if ($this->selected === true) {
            $array["selected"] = $this->selected;
        }
        return $array;
    }

    public function toString(): string
    {
        return \sprintf(
        /** @lang text */
            '<option value="%s"%s>%s</option>',
            $this->value,
            $this->selected ? " selected" : "",
            $this->getTranslator()?->translate($this->text) ?? $this->text
        );
    }

    public function __toString()
    {
        return $this->toString();
    }
}
