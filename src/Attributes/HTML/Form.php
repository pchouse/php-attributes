<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

use PChouse\Attributes\Config\Config;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Form extends CachedForm implements \JsonSerializable, \Stringable
{

    /**
     * @var \PChouse\Attributes\HTML\Element[]
     */
    private array $propertiesElements = [];


    /**
     * @var \PChouse\Attributes\HTML\Element[]
     */
    private array $classElements = [];


    /**
     * @param string|null $id                                          The form id Specifies the character encodings
     *                                                                 that are to be used for the form submission
     * @param string|null $action                                      Specifies where to send the form-data when
     *                                                                 a form is submitted Specifies whether a
     *                                                                 form should have autocomplete on or off
     * @param \PChouse\Attributes\HTML\Enctype|null $enctype           Specifies how the form-data should be encoded
     *                                                                 when submitting
     *                                                                 it to the server (only for method="post")
     * @param \PChouse\Attributes\HTML\Method|null $method             Specifies the HTTP method to use when
     *                                                                 sending form-data
     * @param string|null $name                                        Specifies the name of a form
     * @param bool $novalidate                                         Specifies that the form should not be validated
     *                                                                 when submitted
     * @param \PChouse\Attributes\HTML\Relationship|null $relationship Specifies the relationship between a
     *                                                                 linked resource and the current document
     * @param \PChouse\Attributes\HTML\Target|null $target             Specifies where to display the response that is
     *                                                                 received after submitting the form
     */
    public function __construct(
        private string|null       $id = null,
        private string|null       $acceptCharset = "utf-8",
        private string|null       $action = "/",
        private OnOff|null        $autocomplete = OnOff::OFF,
        private Enctype|null      $enctype = Enctype::MULTIPART,
        private Method|null       $method = Method::POST,
        private string|null       $name = null,
        public bool               $novalidate = false,
        private Relationship|null $relationship = null,
        private Target|null       $target = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     *
     * @return Form
     */
    public function setId(?string $id): Form
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAcceptCharset(): ?string
    {
        return $this->acceptCharset;
    }

    /**
     * @param string|null $acceptCharset
     *
     * @return Form
     */
    public function setAcceptCharset(?string $acceptCharset): Form
    {
        $this->acceptCharset = $acceptCharset;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string|null $action
     *
     * @return Form
     */
    public function setAction(?string $action): Form
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\OnOff|null
     */
    public function getAutocomplete(): ?OnOff
    {
        return $this->autocomplete;
    }

    /**
     * @param \PChouse\Attributes\HTML\OnOff|null $autocomplete
     *
     * @return Form
     */
    public function setAutocomplete(?OnOff $autocomplete): Form
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Enctype|null
     */
    public function getEnctype(): ?Enctype
    {
        return $this->enctype;
    }

    /**
     * @param \PChouse\Attributes\HTML\Enctype|null $enctype
     *
     * @return Form
     */
    public function setEnctype(?Enctype $enctype): Form
    {
        $this->enctype = $enctype;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Method|null
     */
    public function getMethod(): ?Method
    {
        return $this->method;
    }

    /**
     * @param \PChouse\Attributes\HTML\Method|null $method
     *
     * @return Form
     */
    public function setMethod(?Method $method): Form
    {
        $this->method = $method;
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
     * @return Form
     */
    public function setName(?string $name): Form
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function getNovalidate(): bool
    {
        return $this->novalidate;
    }

    /**
     * @param bool $novalidate
     *
     * @return Form
     */
    public function setNovalidate(bool $novalidate): Form
    {
        $this->novalidate = $novalidate;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Relationship|null
     */
    public function getRelationship(): ?Relationship
    {
        return $this->relationship;
    }

    /**
     * @param \PChouse\Attributes\HTML\Relationship|null $relationship
     *
     * @return Form
     */
    public function setRelationship(?Relationship $relationship): Form
    {
        $this->relationship = $relationship;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Target|null
     */
    public function getTarget(): ?Target
    {
        return $this->target;
    }

    /**
     * @param \PChouse\Attributes\HTML\Target|null $target
     *
     * @return Form
     */
    public function setTarget(?Target $target): Form
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Element[]
     */
    public function getPropertiesElements(): array
    {
        return $this->propertiesElements;
    }

    /**
     * @param \PChouse\Attributes\HTML\Element[] $elements
     *
     * @return Form
     * @throws \PChouse\Attributes\HTML\HtmlException
     */
    public function setPropertiesElements(array $elements): Form
    {
        \array_walk($elements, function ($value) {
            if (!($value instanceof Element)) {
                throw new HtmlException("Only Element instances are allowed");
            }
        });
        $this->propertiesElements = $elements;
        return $this;
    }

    /**
     * @param \PChouse\Attributes\HTML\Element $element
     *
     * @return Form
     */
    public function addPropertyElement(Element $element): Form
    {
        $this->propertiesElements[] = $element;
        return $this;
    }

    /**
     * @return \PChouse\Attributes\HTML\Element[]
     */
    public function getClassElements(): array
    {
        return $this->classElements;
    }

    /**
     * @param \PChouse\Attributes\HTML\Element[] $elements
     *
     * @return Form
     * @throws \PChouse\Attributes\HTML\HtmlException
     */
    public function setClassElements(array $elements): Form
    {
        \array_walk($elements, function ($value) {
            if (!($value instanceof Element)) {
                throw new HtmlException("Only Element instances are allowed");
            }
        });
        $this->classElements = $elements;
        return $this;
    }

    /**
     * @param \PChouse\Attributes\HTML\Element $element
     *
     * @return Form
     */
    public function addClassElement(Element $element): Form
    {
        $this->classElements[] = $element;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();
        $values     = [];

        foreach ($properties as $property) {
            if (\in_array($property->getName(), ["propertiesElements", "classElements"])) {
                continue;
            }

            /** @noinspection all */
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if ($value === null || $value === false) {
                continue;
            }

            $key = match ($property->getName()) {
                "acceptCharset" => "accept-charset",
                "relationship"  => "rel",
                default         => $property->getName()
            };

            $values[$key] = ($value instanceof \BackedEnum) ? $value->value : $value;
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
     * @throws \PChouse\Attributes\HTML\SerializeException
     */
    public function toString(): string
    {
        $string = "<form";
        $array  = $this->toArray();
        \array_walk(
            $array,
            function ($value, $key, &$string) {
                $string .= $key === "novalidate" ? " novalidate" : \sprintf(' %s="%s"', $key, $value);
            },
            $string
        );
        $string .= ">";
        return $string;
    }

    /**
     * @throws \PChouse\Attributes\HTML\SerializeException
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param \ReflectionClass $attachedReflectionClass
     *
     * @return \PChouse\Attributes\HTML\Form|\PChouse\Attributes\HTML\CachedForm
     * @throws \PChouse\Attributes\HTML\HtmlException
     */
    public static function parse(\ReflectionClass $attachedReflectionClass): Form|CachedForm
    {

        if (Config::instance()->getHtmlCache()?->cacheExist($attachedReflectionClass) === true) {
            $cachedForm = new CachedForm();
            $cachedForm->setAttachedReflectionClass($attachedReflectionClass);
            return $cachedForm;
        }

        $formAttributes = $attachedReflectionClass->getAttributes(Form::class);
        if (\count($formAttributes) === 0) {
            throw new HtmlException(
                \sprintf("Class '%s' does not have any Form attribute", $attachedReflectionClass->getName())
            );
        }

        /** @var \PChouse\Attributes\HTML\Form $form */
        $form = $formAttributes[0]->newInstance();
        $form->setAttachedReflectionClass($attachedReflectionClass);

        if ($form->getId() === null || \trim($form->getId()) === "") {
            $form->setId($attachedReflectionClass->getShortName());
        }

        $elementClassAttributes = $attachedReflectionClass->getAttributes();

        foreach ($elementClassAttributes as $elementAttribute) {
            if (!\in_array($elementAttribute->getName(), [Element::class, Option::class])) {
                continue;
            }

            /** @var \PChouse\Attributes\HTML\Element|\PChouse\Attributes\HTML\Option $element */
            $element = $elementAttribute->newInstance();

            if ($element instanceof Element) {
                if ($element->getName() === null || \trim($element->getName()) === "") {
                    throw new HtmlException("Elements defined in class must have name");
                }

                if ($element->getId() === null) {
                    $element->setId(
                        \sprintf("%s_%s", $attachedReflectionClass->getShortName(), $element->getName())
                    );
                }
                $form->addClassElement($element);
                continue;
            }

            if ($element instanceof Option) {
                $countClassElements = \count($form->getClassElements());

                if ($countClassElements === 0) {
                    throw new HtmlException("Option attributes must be placed after a Element with tag select");
                }

                $lastElementInStack = $form->classElements[$countClassElements - 1];

                if ($lastElementInStack->getTag() !== Tag::SELECT) {
                    throw new HtmlException("Option attributes must be placed after a Element with tag select");
                }
                $lastElementInStack->addOption($element);
            }
        }

        foreach ($attachedReflectionClass->getProperties() as $property) {
            $propertyElementsAttributes = $property->getAttributes();

            foreach ($propertyElementsAttributes as $elementAttribute) {
                if (!\in_array($elementAttribute->getName(), [Element::class, Option::class])) {
                    continue;
                }

                /** @var \PChouse\Attributes\HTML\Element|\PChouse\Attributes\HTML\Option $element */
                $element = $elementAttribute->newInstance();

                if ($element instanceof Element) {
                    if ($element->getName() === null || \trim($element->getName()) === "") {
                        $element->setName($property->getName());
                    }

                    if ($element->getId() === null || \trim($element->getId()) === "") {
                        $element->setId(
                            \sprintf("%s_%s", $attachedReflectionClass->getShortName(), $element->getName())
                        );
                    }
                    $form->addPropertyElement($element);
                    continue;
                }

                if ($element instanceof Option) {
                    $countPropertiesElements = \count($form->getPropertiesElements());

                    if ($countPropertiesElements === 0) {
                        throw new HtmlException("Option attributes must be placed after a Element with tag select");
                    }

                    $lastElementInStack = $form->propertiesElements[$countPropertiesElements - 1];

                    if ($lastElementInStack->getTag() !== Tag::SELECT) {
                        throw new HtmlException("Option attributes must be placed after a Element with tag select");
                    }
                    $lastElementInStack->addOption($element);
                }
            }
        }

        $form->setClassElements(
            $form->orderElementsPosition(
                $form->getClassElements()
            )
        );

        $form->setPropertiesElements(
            $form->orderElementsPosition(
                $form->getPropertiesElements()
            )
        );

        return $form;
    }

    /**
     * @param \PChouse\Attributes\HTML\Element[] $elements
     *
     * @return \PChouse\Attributes\HTML\Element[]
     */
    public function orderElementsPosition(array $elements): array
    {
        $newPosition = [];

        foreach ($elements as $element) {
            if ($element->getPosition() === null) {
                $newPosition[] = $element;
                continue;
            }

            $position = $element->getPosition() - 1;

            if (!\array_key_exists($position, $newPosition)) {
                $newPosition[$position] = $element;
                \ksort($newPosition);
                continue;
            }

            $newPosition = \array_values($newPosition);
            \ksort($newPosition);

            \array_splice($newPosition, $position, 0, [$element]);
        }

        return \array_values($newPosition);
    }


    /**
     * @throws \PChouse\Attributes\HTML\SerializeException
     * @throws \PChouse\Attributes\HTML\HtmlException
     * @throws \PChouse\Attributes\HTML\Cache\CacheException
     */
    public function toStackArray(): array
    {
        $ids                 = [];
        $stack               = [];
        $stack["form"]       = $this->toArray();
        $stack["class"]      = [];
        $stack["properties"] = [];

        if ($this->getId() !== null && \trim($this->getId()) !== "") {
            $ids[] = $this->getId();
        }

        foreach ($this->getClassElements() as $element) {
            if ($element->getId() !== null && \trim($element->getId()) !== "") {
                if (\array_key_exists($element->getId(), $ids)) {
                    throw new HtmlException(
                        \sprintf("Element ID %s exists more then once", $element->getId())
                    );
                }
                $stack["class"][$element->getId()] = $element->toArray();
                $ids[]                             = $element->getId();
                continue;
            }
            $stack["class"][] = $element->toArray();
        }

        foreach ($this->getPropertiesElements() as $element) {
            if ($element->getName() === null || \trim($element->getName()) === "") {
                throw new HtmlException("Property element without name");
            }

            if (!\array_key_exists($element->getName(), $stack["properties"])) {
                $stack["properties"][$element->getName()] = [];
            }

            if ($element->getId() !== null && \trim($element->getId()) !== "") {
                if (\array_key_exists($element->getId(), $ids)) {
                    throw new HtmlException(
                        \sprintf("Element ID %s exists more then once", $element->getId())
                    );
                }

                $ids[]                                                       = $element->getId();
                $stack["properties"][$element->getName()][$element->getId()] = $element->toArray();
                continue;
            }
            $stack["properties"][$element->getName()][] = $element->toArray();
        }

        Config::instance()->getHtmlCache()?->putInCache(
            $this->getAttachedReflectionClass() ?? new \ReflectionClass($this),
            $stack
        );

        return $stack;
    }
}
