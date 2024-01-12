<?php
declare(strict_types=1);

namespace PChouse\Attributes\HTML;

enum Accept: string
{
    case AUDIO = "audio/*";
    case VIDEO = "video/*";
    case IMAGE = "image/*";
}
