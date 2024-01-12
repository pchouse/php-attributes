# PChouse PHP Attributes

--- 

##### A PHP

#### Install

```bash 
composer require pchouse/php-attributes
``` 

This library is a set of PHP attributes to define class and properties metadata to help the
implementation of HTML templates and database models

#### Usage

The object:

```php
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
```

Type mapper

```php
<?php
declare(strict_types=1);

namespace PChouse\Resources;

use PChouse\Attributes\Db\TypeMap;
use PChouse\Attributes\Db\Types;
use Rebelo\Date\Date;
use Rebelo\Decimal\Decimal;

class MyTypeMap extends TypeMap
{
    public function dbTypeFor(string $propertyType): ?Types
    {
        return match ($propertyType) {
            Decimal::class => Types::DB_DECIMAL,
            Date::class    => Types::DB_DATE,
            default        => parent::dbTypeFor($propertyType)
        };
    }
}
```

Get the Database metadata:

```php
$reflectionClass = new \ReflectionClass(MyClass::class);
$myTypeMap       = new MyTypeMap();
$table           = Table::parse($reflectionClass); // Table
$columns         = Column::parse($reflectionClass, $myTypeMap); // array<string, Column>
```

Get the Form metadata:

```php

$form = Form::parse(new \ReflectionClass(MyClass::class));
if($form instanceof \PChouse\Attributes\HTML\Form)){
    // Set other properties
}

$array = $form->toStackArray(); // The returned array can be used with twig macros

```

--- 
License MIT

Copyright 2023 Reflexão, Sistemas e Estudos Informáticos, Lda

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction,
including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or
substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
THE USE OR OTHER DEALINGS IN THE SOFTWARE.

--- 

##### Art made by a Joseon Chinnampo soul for smart people 🇰🇷
