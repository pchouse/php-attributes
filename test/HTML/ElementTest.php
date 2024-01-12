<?php
declare(strict_types=1);

namespace PChouse\HTML;

use PChouse\Attributes\HTML\Accept;
use PChouse\Attributes\HTML\Element;
use PChouse\Attributes\HTML\InputType;
use PChouse\Attributes\HTML\OnOff;
use PChouse\Attributes\HTML\Tag;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{

    /**
     * @test
     * @return \PChouse\Attributes\HTML\Element
     * @noinspection PhpConditionAlreadyCheckedInspection
     * @throws \PChouse\Attributes\AttributesException
     */
    public function testInstance(): Element
    {
        $tag          = Tag::INPUT;
        $type         = InputType::TEXT;
        $name         = "element_name";
        $id           = "element_id";
        $accept       = Accept::IMAGE;
        $autocomplete = OnOff::ON;
        $autofocus    = true;
        $checked      = true;
        $dirname      = "input.dir";
        $disabled     = true;
        $form         = "form_id";
        $max          = 999;
        $maxLength    = 99;
        $min          = 9;
        $minLength    = 19;
        $multiple     = true;
        $pattern      = "[A-Z]";
        $placeholder  = "The placeholder";
        $readonly     = true;
        $required     = true;
        $size         = 49;
        $step         = 29;
        $value        = "The value";
        $title        = "The title";
        $tabindex     = -1;
        $position     = 59;
        $layoutWeight = 0;

        $element = new Element(
            $tag,
            $type,
            $name,
            $id,
            $accept,
            $autocomplete,
            $autofocus,
            $checked,
            $dirname,
            $disabled,
            $form,
            $max,
            $maxLength,
            $min,
            $minLength,
            $multiple,
            $pattern,
            $placeholder,
            $readonly,
            $required,
            $size,
            $step,
            $value,
            $title,
            $tabindex,
            $position,
            $layoutWeight,
        );

        $this->assertSame($tag, $element->getTag());
        $this->assertSame($type, $element->getType());
        $this->assertSame($name, $element->getName());
        $this->assertSame($id, $element->getId());
        $this->assertSame($accept, $element->getAccept());
        $this->assertSame($autocomplete, $element->getAutocomplete());
        $this->assertSame($autofocus, $element->getIsAutofocus());
        $this->assertSame($checked, $element->getIsChecked());
        $this->assertSame($dirname, $element->getDirname());
        $this->assertSame($disabled, $element->isDisabled());
        $this->assertSame($form, $element->getForm());
        $this->assertSame($max, $element->getMax());
        $this->assertSame($maxLength, $element->getMaxLength());
        $this->assertSame($min, $element->getMin());
        $this->assertSame($minLength, $element->getMinLength());
        $this->assertSame($multiple, $element->getIsMultiple());
        $this->assertSame($pattern, $element->getPattern());
        $this->assertSame($placeholder, $element->getPlaceholder());
        $this->assertSame($readonly, $element->getIsReadonly());
        $this->assertSame($required, $element->getIsRequired());
        $this->assertSame($size, $element->getSize());
        $this->assertSame($step, $element->getStep());
        $this->assertSame($value, $element->getValue());
        $this->assertSame($title, $element->getTitle());
        $this->assertSame($tabindex, $element->getTabindex());
        $this->assertSame($position, $element->getPosition());
        $this->assertSame($layoutWeight, $element->getLayoutWeight());

        return $element;
    }

    /**
     * @depends testInstance
     *
     * @param \PChouse\Attributes\HTML\Element $element
     *
     * @return void
     * @throws \PChouse\Attributes\HTML\SerializeException
     */
    public function testToArray(Element $element): void
    {
        $array = $element->toArray();
        $this->assertSame(
            $array,
            [
                "tag" => Tag::INPUT->value,
                "type" => InputType::TEXT->value,
                "name" => "element_name",
                "id" => "element_id",
                "accept" => Accept::IMAGE->value,
                "autocomplete" => OnOff::ON->value,
                "autofocus" => true,
                "checked" => true,
                "dirname" => "input.dir",
                "disabled" => true,
                "form" => "form_id",
                "max" => 999,
                "maxLength" => 99,
                "min" => 9,
                "minLength" => 19,
                "multiple" => true,
                "pattern" => "[A-Z]",
                "placeholder" => "The placeholder",
                "readonly" => true,
                "required" => true,
                "size" => 49,
                "step" => 29,
                "value" => "The value",
                "title" => "The title",
                "tabindex" => -1,
                "position" => 59,
                "layoutWeight" => 0,
            ]
        );
    }
}
