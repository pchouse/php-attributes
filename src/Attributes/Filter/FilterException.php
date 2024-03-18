<?php
declare(strict_types=1);

namespace PChouse\Attributes\Filter;

use JetBrains\PhpStorm\Pure;

class FilterException extends \Exception
{
    #[Pure]
    public function __construct(string $message = "", int $code = 0, ? \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}