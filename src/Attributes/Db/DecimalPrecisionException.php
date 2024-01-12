<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db;

use JetBrains\PhpStorm\Pure;

class DecimalPrecisionException extends ColumnAttributeException
{
    #[Pure] public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
