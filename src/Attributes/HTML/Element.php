<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

use PChouse\Attributes\AAttributes;
use PChouse\Attributes\AttributesException;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Element extends AAttributes implements \JsonSerializable, \Stringable
{
    /**
     * @var \PChouse\Attributes\HTML\Option[]
     */
    private array $options = [];

    /**
     * @param \PChouse\Attributes\HTML\Tag|null $tag                   The HTML tag
     * @param \PChouse\Attributes\HTML\InputType|null $type            Specifies the type <input> element to display
     * @param string|null $name                                        Specifies the name of an <input> element
     * @param string|null $id                                          The html element id
     * @param \PChouse\Attributes\HTML\Accept|string|null $accept      Specifies a filter for what file types the user
     *                                                                 can pick from the file input dialog box
     *                                                                 (only for type="file")
     *                                                                 Can be teh file_extension,
     *                                                                 media_type or one of the enumeration Accept
     * @param \PChouse\Attributes\HTML\OnOff|string|null $autocomplete Specifies whether an <input> element should have
     *                                                                 autocomplete enabled
     * @param bool $autofocus                                          Specifies that an <input> element should
     *                                                                 automatically get focus when the page loads
     * @param bool $checked                                            Specifies that an <input> element should
     *                                                                 be pre-selected when
     *                                                                 the page loads (for type="checkbox"
     *                                                                 or type="radio")
     * @param string|null $dirname                                     Specifies that the text direction will
     *                                                                 be submitted
     * @param bool $disabled                                           Specifies that an <input> element
     *                                                                 should be disabled
     * @param string|null $form                                        Specifies the form id the input element
     *                                                                 belongs to
     * @param string|int|float|null $max                               Specifies the maximum value for an input element,
     *                                                                 number or date
     * @param int|null $maxLength                                      Specifies the maximum number of characters
     *                                                                 allowed in an input element
     * @param string|int|float|null $min                               Specifies a minimum value for an input element
     * @param int|null $minLength                                      Specifies the minimum number of
     *                                                                 characters required in an <input> element
     * @param bool $multiple                                           Specifies that a user can enter more than
     *                                                                 one value in an <input> element
     * @param string|null $pattern                                     Specifies a regular expression that
     *                                                                 an input element's value is checked against
     * @param string|null $placeholder                                 Specifies a short hint that describes the
     *                                                                 expected value of an input element
     * @param bool $readonly                                           Specifies that an input field is read-only
     * @param bool $required                                           Specifies that an input field must be
     *                                                                 filled out before submitting the form
     * @param int|null $size                                           Specifies the width, in characters,
     *                                                                 of an input element
     * @param int|float|null $step                                     Specifies the interval between legal
     *                                                                 numbers in an input field
     * @param string|null $value                                       Specifies the value of an input element
     * @param string|null $title                                       Specifies the title of an input element
     * @param int|null $tabindex                                       The tabindex
     * @param int|null $position                                       The position in the form
     * @param int|null $layoutWeight                                   The weight of the element in layout
     * @param int $layoutRowIndex
     * @param int|null $layoutTabIndex
     */
    public function __construct(
        private Tag|null              $tag = null,
        private InputType|null        $type = null,
        private string|null           $name = null,
        private string|null           $id = null,
        private Accept|string|null    $accept = null,
        private OnOff|string|null     $autocomplete = OnOff::OFF,
        private bool                  $autofocus = false,
        private bool                  $checked = false,
        private string|null           $dirname = null,
        private bool                  $disabled = false,
        private string|null           $form = null,
        private string|int|float|null $max = null,
        private int|null              $maxLength = null,
        private string|int|float|null $min = null,
        private int|null              $minLength = null,
        private bool                  $multiple = false,
        private string|null           $pattern = null,
        private string|null           $placeholder = null,
        private bool                  $readonly = false,
        private bool                  $required = false,
        private int|null              $size = null,
        private int|float|null        $step = null,
        private string|null           $value = "",
        private string|null           $title = null,
        private int|null              $tabindex = null,
        private int|null              $position = null,
        private int|null              $layoutWeight = null,
        private int                   $layoutRowIndex = 0,
        private int|null              $layoutTabIndex = null,
    ) {
    }

    /**
     * @throws \PChouse\Attributes\AttributesException
     */
    protected function validateType(): void
    {
        if ($this->tag === null) {
            throw new AttributesException(
                "Element tag must be defined"
            );
        }

        if ($this->tag === Tag::INPUT && $this->type === null) {
            throw new AttributesException(
                "Element with tag input must have the type defined"
            );
        }
    }


    /**
     * Html tag
     *
     * @return \PChouse\Attributes\HTML\Tag|null
     */
    public function getTag(): Tag|null
    {
        return $this->tag;
    }

    /**
     * Html tag
     *
     * @param \PChouse\Attributes\HTML\Tag $tag
     *
     * @return Element
     */
    public function setTag(Tag $tag): Element
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Specifies the type <input> element to display
     *
     * @return \PChouse\Attributes\HTML\InputType|null
     */
    public function getType(): ?InputType
    {
        return $this->type;
    }

    /**
     * Specifies the type <input> element to display
     *
     * @param \PChouse\Attributes\HTML\InputType|null $type
     *
     * @return Element
     */
    public function setType(?InputType $type): Element
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Specifies the name of an <input> element
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Specifies the name of an <input> element
     *
     * @param string|null $name
     *
     * @return Element
     */
    public function setName(?string $name): Element
    {
        $this->name = $name;
        return $this;
    }

    /**
     * The html element id
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * The html element id
     *
     * @param string|null $id
     *
     * @return Element
     */
    public function setId(?string $id): Element
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Specifies a filter for what file types the user can pick from
     * the file input dialog box (only for type="file")
     * Can be teh file_extension, media_type or one of the enumeration Accept
     *
     * @return \PChouse\Attributes\HTML\Accept|string|null
     */
    public function getAccept(): Accept|string|null
    {
        return $this->accept;
    }

    /**
     * Specifies a filter for what file types the user can pick from
     * the file input dialog box (only for type="file")
     * Can be teh file_extension, media_type or one of the enumeration Accept
     *
     * @param \PChouse\Attributes\HTML\Accept|string|null $accept
     *
     * @return Element
     */
    public function setAccept(Accept|string|null $accept): Element
    {
        $this->accept = $accept;
        return $this;
    }

    /**
     * Specifies whether an <input> element should have autocomplete enabled
     *
     * @return \PChouse\Attributes\HTML\OnOff|string|null
     */
    public function getAutocomplete(): OnOff|string|null
    {
        return $this->autocomplete;
    }

    /**
     * Specifies whether an <input> element should have autocomplete enabled
     *
     * @param \PChouse\Attributes\HTML\OnOff|string|null $autocomplete
     *
     * @return Element
     */
    public function setAutocomplete(OnOff|string|null $autocomplete): Element
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    /**
     * Specifies that an <input> element should automatically get focus when the page loads
     *
     * @return bool
     */
    public function getIsAutofocus(): bool
    {
        return $this->autofocus;
    }

    /**
     * Specifies that an <input> element should automatically get focus when the page loads
     *
     * @param bool $autofocus
     *
     * @return Element
     */
    public function setIsAutofocus(bool $autofocus): Element
    {
        $this->autofocus = $autofocus;
        return $this;
    }

    /**
     * Specifies that an <input> element should be pre-selected when the page
     * loads (for type="checkbox" or type="radio")
     *
     * @return bool
     */
    public function getIsChecked(): bool
    {
        return $this->checked;
    }

    /**
     * Specifies that an <input> element should be pre-selected when the page
     * loads (for type="checkbox" or type="radio")
     *
     * @param bool $checked
     *
     * @return Element
     */
    public function setIsChecked(bool $checked): Element
    {
        $this->checked = $checked;
        return $this;
    }

    /**
     * Specifies that the text direction will be submitted
     *
     * @return string|null
     */
    public function getDirname(): ?string
    {
        return $this->dirname;
    }

    /**
     * Specifies that the text direction will be submitted
     *
     * @param string|null $dirname
     *
     * @return Element
     */
    public function setDirname(?string $dirname): Element
    {
        $this->dirname = $dirname;
        return $this;
    }

    /**
     * Specifies that an <input> element should be disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Specifies that an <input> element should be disabled
     *
     * @param bool $disabled
     *
     * @return Element
     */
    public function setDisabled(bool $disabled): Element
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Specifies the form id the <input> element belongs to
     *
     * @return string|null
     */
    public function getForm(): ?string
    {
        return $this->form;
    }

    /**
     * Specifies the form id the <input> element belongs to
     *
     * @param string|null $form
     *
     * @return Element
     */
    public function setForm(?string $form): Element
    {
        $this->form = $form;
        return $this;
    }

    /**
     * Specifies the maximum value for an <input> element, number or date
     *
     * @return int|float|string|null
     */
    public function getMax(): int|float|string|null
    {
        return $this->max;
    }

    /**
     * Specifies the maximum value for an <input> element, number or date
     *
     * @param int|float|string|null $max
     *
     * @return Element
     */
    public function setMax(int|float|string|null $max): Element
    {
        $this->max = $max;
        return $this;
    }

    /**
     * Specifies the maximum number of characters allowed in an <input> element
     *
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    /**
     * Specifies the maximum number of characters allowed in an <input> element
     *
     * @param int|null $maxLength
     *
     * @return Element
     */
    public function setMaxLength(?int $maxLength): Element
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * Specifies a minimum value for an <input> element
     *
     * @return int|float|string|null
     */
    public function getMin(): int|float|string|null
    {
        return $this->min;
    }

    /**
     * Specifies a minimum value for an <input> element
     *
     * @param int|float|string|null $min
     *
     * @return Element
     */
    public function setMin(int|float|string|null $min): Element
    {
        $this->min = $min;
        return $this;
    }

    /**
     * Specifies the minimum number of characters required in an <input> element
     *
     * @return int|null
     */
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * Specifies the minimum number of characters required in an <input> element
     *
     * @param int|null $minLength
     *
     * @return Element
     */
    public function setMinLength(?int $minLength): Element
    {
        $this->minLength = $minLength;
        return $this;
    }

    /**
     * Specifies that a user can enter more than one value in an <input> element
     *
     * @return bool
     */
    public function getIsMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * Specifies that a user can enter more than one value in an <input> element
     *
     * @param bool $multiple
     *
     * @return Element
     */
    public function setIsMultiple(bool $multiple): Element
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * Specifies a regular expression that an <input> element's value is checked against
     *
     * @return string|null
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * Specifies a regular expression that an <input> element's value is checked against
     *
     * @param string|null $pattern
     *
     * @return Element
     */
    public function setPattern(?string $pattern): Element
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Specifies a short hint that describes the expected value of an <input> element
     *
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * Specifies a short hint that describes the expected value of an <input> element
     *
     * @param string|null $placeholder
     *
     * @return Element
     */
    public function setPlaceholder(?string $placeholder): Element
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * Specifies that an input field is read-only
     *
     * @return bool
     */
    public function getIsReadonly(): bool
    {
        return $this->readonly;
    }

    /**
     * Specifies that an input field is read-only
     *
     * @param bool $readonly
     *
     * @return Element
     */
    public function setIsReadonly(bool $readonly): Element
    {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * Specifies that an input field must be filled out before submitting the form
     *
     * @return bool
     */
    public function getIsRequired(): bool
    {
        return $this->required;
    }

    /**
     * Specifies that an input field must be filled out before submitting the form
     *
     * @param bool $required
     *
     * @return Element
     */
    public function setIsRequired(bool $required): Element
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Specifies the width, in characters, of an <input> element
     *
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Specifies the width, in characters, of an <input> element
     *
     * @param int|null $size
     *
     * @return Element
     */
    public function setSize(?int $size): Element
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Specifies the interval between legal numbers in an input field
     *
     * @return int|float|null
     */
    public function getStep(): int|float|null
    {
        return $this->step;
    }

    /**
     * Specifies the interval between legal numbers in an input field
     *
     * @param int|float|null $step
     *
     * @return Element
     */
    public function setStep(int|float|null $step): Element
    {
        $this->step = $step;
        return $this;
    }

    /**
     * Specifies the value of an <input> element
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Specifies the value of an <input> element
     *
     * @param string|null $value
     *
     * @return Element
     */
    public function setValue(?string $value): Element
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return Element
     */
    public function setTitle(?string $title): Element
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTabindex(): ?int
    {
        return $this->tabindex;
    }

    /**
     * @param int|null $tabindex
     *
     * @return Element
     */
    public function setTabindex(?int $tabindex): Element
    {
        $this->tabindex = $tabindex;
        return $this;
    }

    /**
     * The position in the form
     *
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * The position in the form
     *
     * @param int|null $position
     *
     * @return Element
     */
    public function setPosition(?int $position): Element
    {
        $this->position = $position;
        return $this;
    }

    /**
     * The weight of the element in layout
     *
     * @return int|null
     */
    public function getLayoutWeight(): ?int
    {
        return $this->layoutWeight;
    }

    /**
     * The weight of the element in layout
     *
     * @param int|null $layoutWeight
     *
     * @return Element
     */
    public function setLayoutWeight(?int $layoutWeight): Element
    {
        $this->layoutWeight = $layoutWeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getLayoutRowIndex(): int
    {
        return $this->layoutRowIndex;
    }

    /**
     * @param int $layoutRowIndex
     *
     * @return Element
     */
    public function setLayoutRowIndex(int $layoutRowIndex): Element
    {
        $this->layoutRowIndex = $layoutRowIndex;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLayoutTabIndex(): ?int
    {
        return $this->layoutTabIndex;
    }

    /**
     * @param int|null $layoutTabIndex
     *
     * @return Element
     */
    public function setLayoutTabIndex(?int $layoutTabIndex): Element
    {
        $this->layoutTabIndex = $layoutTabIndex;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param \PChouse\Attributes\HTML\Option[] $options
     *
     * @return Element
     * @throws \PChouse\Attributes\HTML\HtmlException
     */
    public function setOptions(array $options): Element
    {
        if ($this->tag !== Tag::SELECT) {
            throw new HtmlException("Options are only allowed for select tag");
        }

        \array_walk($options, function ($value) {
            if (!($value instanceof Option)) {
                throw new HtmlException(
                    \sprintf("Option is not an instance of '%s'", Option::class)
                );
            }
        });
        $this->options = $options;
        return $this;
    }

    /**
     * @param \PChouse\Attributes\HTML\Option $option
     *
     * @return Element
     * @throws \PChouse\Attributes\HTML\HtmlException
     */
    public function addOption(Option $option): Element
    {
        if ($this->tag !== Tag::SELECT) {
            throw new HtmlException("Options are only allowed for select tag");
        }

        $this->options[] = $option;
        return $this;
    }

    /**
     * @return array
     * @throws \PChouse\Attributes\AttributesException
     */
    public function jsonSerialize(): array
    {
        $this->validateType();
        $reflection        = new \ReflectionClass($this);
        $properties        = $reflection->getProperties();
        $values            = [];
        $values["options"] = [];
        foreach ($properties as $property) {
            $key = $property->getName();

            /** @noinspection all */
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if ($value === null || $value === false) {
                continue;
            }

            if ($key === "options") {
                if (\is_array($value)) {
                    /** @var \PChouse\Attributes\HTML\Option $option */
                    foreach ($value as $option) {
                        $values["options"][] = $option->toArray();
                    }
                }
            } elseif ($key === "placeholder" || $key === "title") {
                $values[$key] = $this->getTranslator()?->translate($value) ?? $value;
            } else {
                $values[$key] = ($value instanceof \BackedEnum) ? $value->value : $value;
            }
        }

        if ($this->tag !== Tag::SELECT) {
            unset($values["options"]);
        }

        return $values;
    }

    /**
     * @return array
     * @throws \PChouse\Attributes\HTML\SerializeException
     */
    public function toArray(): array
    {
        if (false === $json = \json_encode($this)) {
            throw new SerializeException("Fail serializing to json");
        }

        $array = \json_decode($json, true, flags: JSON_OBJECT_AS_ARRAY);

        if (!\is_array($array)) {
            throw new SerializeException("Fail serializing to json");
        }

        return $array;
    }

    /**
     * @return string
     * @throws \PChouse\Attributes\HTML\SerializeException
     * @throws \PChouse\Attributes\AttributesException
     */
    public function toString(): string
    {
        $this->validateType();
        $array  = $this->toArray();
        $string = "<" . ($this->tag?->value ?? "");
        unset($array["tag"]);
        \array_walk(
            $array,
            function ($value, $key, &$string) {
                if ($key === "options") {
                    return;
                }
                $string .= $value === true ? " " . $key : \sprintf(' %s="%s"', $key, $value);
            },
            $string
        );

        if ($this->tag !== Tag::SELECT) {
            $string .= "/>";
            return $string;
        }

        foreach ($this->options as $option) {
            $string .= $option->toString();
        }

        $string .= "</select>";
        return $string;
    }

    /**
     * @throws \PChouse\Attributes\HTML\SerializeException
     * @throws \PChouse\Attributes\AttributesException
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
