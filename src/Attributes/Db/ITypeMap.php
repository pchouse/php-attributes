<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db;

interface ITypeMap
{
    public function dbTypeFor(string $propertyType): ?Types;
}
