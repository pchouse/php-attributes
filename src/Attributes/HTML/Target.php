<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

enum Target: string
{
    case BLANK  = "_blank";
    case SELF   = "_self";
    case PARENT = "_parent";
    case TOP    = "_top";
}
