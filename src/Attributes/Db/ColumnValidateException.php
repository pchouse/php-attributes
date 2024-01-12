<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db;

use JetBrains\PhpStorm\Pure;

class ColumnValidateException extends ColumnAttributeException
{

    const PROPERTY_NAME_NOT_EXIST   = 900001;
    const VALUE_TYPE_NOT_VALID      = 900002;
    const NULL_NOT_ALLOWED          = 900003;
    const EXCEEDS_MAXIMUM_LENGTH    = 900004;
    const LESS_THAN_MINIMUM_LENGTH  = 900005;
    const VALUE_GRATER_THAN         = 900007;
    const VALUE_LESS_THAN           = 900008;
    const EXCEEDS_MAXIMUM_PRECISION = 900009;
    const EXCEEDS_MAXIMUM_SCALE     = 900010;
    const FAIL_REGEXP               = 900011;


    #[Pure] public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
