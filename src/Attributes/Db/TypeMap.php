<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db;

class TypeMap implements ITypeMap
{

    public function dbTypeFor(string $propertyType): ?Types
    {
        return match ($propertyType) {
            "string" => Types::DB_STRING,
            "float"  => Types::DB_DECIMAL,
            "int"    => Types::DB_INT,
            "bool"   => Types::DB_BOOLEAN,
            default  => null
        };
    }
}
