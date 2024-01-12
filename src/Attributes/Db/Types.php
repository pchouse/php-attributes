<?php
declare(strict_types=1);

namespace PChouse\Attributes\Db;

enum Types: int
{
    case DB_STRING = 1;

    /**
     * DB Integer type
     */
    case DB_INT = 2;

    /**
     * DB Date type
     */
    case DB_DATE = 4;

    /**
     * Datetime type
     */
    case DB_DATETIME = 5;

    /**
     * DB Boolean type
     */
    case DB_BOOLEAN = 6;

    /**
     * DB Binary type
     */
    case DB_BLOB = 7;

    /**
     * DB UDecimal type
     */
    case DB_DECIMAL = 8;

    /**
     * DB time type
     */
    case DB_TIME = 9;

    /**
     * DB timestamp type
     */
    case DB_TIMESTAMP = 10;
}
