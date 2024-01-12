<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

enum Method: string
{
    case GET  = "get";
    case POST = "post";
}
