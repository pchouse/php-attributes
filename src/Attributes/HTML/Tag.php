<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

enum Tag: string
{
    case INPUT = "input";
    case TEXT_AREA = "textarea";
    case SELECT = "select";
}
