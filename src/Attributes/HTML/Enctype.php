<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

enum Enctype: string
{
    case FORM_URLENCODED = "application/x-www-form-urlencoded";
    case MULTIPART       = "multipart/form-data";
    case TEXT_PALIN      = "text/plain";
}
