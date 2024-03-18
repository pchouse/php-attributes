<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db\Cache;

use JetBrains\PhpStorm\Pure;
use PChouse\Attributes\CacheException;

class DbCacheException extends CacheException
{
    #[Pure] public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
