<?php
declare(strict_types=1);

namespace PChouse\Attributes;

interface ITranslator
{

    public function translate(string $key): string;
}
