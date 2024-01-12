<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

use JetBrains\PhpStorm\Pure;
use PChouse\Attributes\AttributesException;

class HtmlException extends AttributesException
{
    #[Pure] public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
