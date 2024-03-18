<?php
declare(strict_types=1);

namespace PChouse\Attributes;

use JetBrains\PhpStorm\Pure;

class CacheException extends \Exception
{
    #[Pure]
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}