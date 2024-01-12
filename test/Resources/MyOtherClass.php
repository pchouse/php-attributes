<?php
/** @noinspection ALL */
declare(strict_types=1);

namespace PChouse\Resources;

use PChouse\Attributes\Db\Column;
use PChouse\Attributes\Db\Table;
use PChouse\Attributes\Db\Types;
use Rebelo\Date\Date;
use Rebelo\Decimal\Decimal;

#[Table(name: "my_table", isView: true)]
class MyOtherClass
{
    #[Column(name: "c_string", type: Types::DB_STRING, maximumLength: 99, minimumLength: 9)]
    private string $columnString;

    #[Column(name: "c_int", type: Types::DB_TIMESTAMP, minimum: 0, maximum: 9999999)]
    private int $columnInt;

    #[Column]
    private float $columnFloat;

    #[Column]
    private bool $columnBool;

    #[Column]
    private Date $columnDate;

    #[Column(name: "c_decimal", type: Types::DB_DECIMAL, decimalPrecision: 9, decimalScale: 2)]
    private Decimal $columnDecimal;

    #[Column]
    private ?string $columnStringNull;
}