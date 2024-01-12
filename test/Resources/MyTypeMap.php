<?php
declare(strict_types=1);

namespace PChouse\Resources;

use PChouse\Attributes\Db\TypeMap;
use PChouse\Attributes\Db\Types;
use Rebelo\Date\Date;
use Rebelo\Decimal\Decimal;

class MyTypeMap extends TypeMap
{
    public function dbTypeFor(string $propertyType): ?Types
    {
        return match ($propertyType) {
            Decimal::class => Types::DB_DECIMAL,
            Date::class    => Types::DB_DATE,
            default        => parent::dbTypeFor($propertyType)
        };
    }
}
