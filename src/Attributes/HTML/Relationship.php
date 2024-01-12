<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

enum Relationship: string
{
    case  EXTERNAL    = "external";
    case  HELP        = "help";
    case  LICENSE     = "license";
    case  NEXT        = "next";
    case  NOFOLLOW    = "nofollow";
    case  NO_OPENER   = "noopener";
    case  NO_REFERRER = "noreferrer";
    case  OPENER      = "opener";
    case  PREV        = "prev";
    case  SEARCH      = "search";
}