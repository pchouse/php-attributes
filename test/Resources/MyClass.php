<?php
/** @noinspection ALL */
declare(strict_types=1);

namespace PChouse\Resources;

use PChouse\Attributes\Db\Column;
use PChouse\Attributes\Db\Table;
use PChouse\Attributes\Db\Types;
use PChouse\Attributes\HTML\Element;
use PChouse\Attributes\HTML\Form;
use PChouse\Attributes\HTML\InputType;
use PChouse\Attributes\HTML\Option;
use PChouse\Attributes\HTML\Tag;
use Rebelo\Date\Date;
use Rebelo\Decimal\Decimal;

#[Table]
#[Form(novalidate: true)]
#[Element(tag: Tag::INPUT, type: InputType::HIDDEN, name: "hidden1")]
#[Element(tag: Tag::INPUT, type: InputType::HIDDEN, name: "hidden2")]
#[Element(tag: Tag::SELECT, name: "select1")]
#[Option(value: "", text: "Select", selected: false)]
#[Option(value: "1", text: "Option1", selected: true)]
class MyClass
{
    #[Element(tag: Tag::INPUT, type: InputType::TEXT, position: 9)]
    #[Column]
    private string $columnString;

    #[Element(tag: Tag::INPUT, type: InputType::NUMBER, position: 7)]
    #[Column]
    private int $columnInt;

    #[Element(tag: Tag::INPUT, type: InputType::RADIO, id: "my_class_column_float_1")]
    #[Element(tag: Tag::INPUT, type: InputType::RADIO, id: "my_class_column_float_2")]
    #[Element(tag: Tag::INPUT, type: InputType::RADIO, id: "my_class_column_float_3")]
    #[Column]
    private float $columnFloat;

    #[Element(tag: Tag::INPUT, type: InputType::CHECKBOX,)]
    #[Column]
    private bool $columnBool;

    #[Element(tag: Tag::INPUT, type: InputType::CHECKBOX,)]
    #[Column]
    private Date $columnDate;

    #[Element(tag: Tag::SELECT, name: "select2")]
    #[Option(value: "", text: "Select")]
    #[Option(value: "9", text: "Option with 9")]
    #[Option(value: "99", text: "Option with 999")]
    #[Column]
    private Decimal $columnDecimal;

    #[Element(tag: Tag::INPUT, type: InputType::TEXT, position: 1)]
    #[Column]
    private ?string $columnStringNull;
}
