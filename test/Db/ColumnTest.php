<?php
declare(strict_types=1);

namespace PChouse\Db;

use PChouse\Attributes\Config\Config;
use PChouse\Attributes\Db\Cache\Cache;
use PChouse\Attributes\Db\Cache\ICache;
use PChouse\Attributes\Db\Column;
use PChouse\Attributes\Db\ColumnValidateException;
use PChouse\Attributes\Db\DecimalPrecisionException;
use PChouse\Attributes\Db\DecimalScaleException;
use PChouse\Attributes\Db\MaximumLengthException;
use PChouse\Attributes\Db\MinimumLengthException;
use PChouse\Attributes\Db\Types;
use PChouse\Resources\MyClass;
use PChouse\Resources\MyOtherClass;
use PChouse\Resources\MyTypeMap;
use PHPUnit\Framework\TestCase;

class ColumnTest extends TestCase
{

    /**
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function setUp(): void
    {
        Cache::instance()->clearCache();
        Config::instance()->setDbCache(Cache::instance());
    }

    /**
     * @test
     * @return void
     */
    public function testInstanceNoArguments(): void
    {
        $column = new Column();
        $this->assertNull($column->getName());
        $this->assertNull($column->getType());
        $this->assertNull($column->getMaximumLength());
        $this->assertNull($column->getMinimumLength());
        $this->assertNull($column->getMaximum());
        $this->assertNull($column->getMinimum());
        $this->assertNull($column->getDecimalPrecision());
        $this->assertNull($column->getDecimalScale());
        $this->assertNull($column->getRegExp());
        $this->assertFalse($column->getIsPrimaryKey());
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testInstanceWithArguments(): void
    {
        $name             = "table_name";
        $type             = Types::DB_STRING;
        $maximumLength    = 999;
        $minimumLength    = 9;
        $maximum          = 4999;
        $minimum          = 1999;
        $decimalPrecision = 19;
        $decimalScale     = 4;
        $regExp           = "/^[A-Za-z$/";


        $column = new Column(
            name: $name,
            type: $type,
            maximumLength: $maximumLength,
            minimumLength: $minimumLength,
            maximum: $maximum,
            minimum: $minimum,
            decimalPrecision: $decimalPrecision,
            decimalScale: $decimalScale,
            regExp: $regExp,
            isPrimaryKey: true,
            isPKAutoIncrement: false
        );

        $this->assertSame($name, $column->getName());
        $this->assertSame($type, $column->getType());
        $this->assertSame($maximumLength, $column->getMaximumLength());
        $this->assertSame($minimumLength, $column->getMinimumLength());
        $this->assertSame($maximum, $column->getMaximum());
        $this->assertSame($minimum, $column->getMinimum());
        $this->assertSame($decimalPrecision, $column->getDecimalPrecision());
        $this->assertSame($decimalScale, $column->getDecimalScale());
        $this->assertSame($regExp, $column->getRegExp());
        $this->assertTrue($column->getIsPrimaryKey());
        $this->assertFalse($column->getIsPKAutoIncrement());
    }

    /**
     * @return void
     */
    public function testAutoSetAutoincrement(): void
    {
        $column = new Column(
            isPrimaryKey: true
        );

        $this->assertTrue($column->getIsPKAutoIncrement());
    }

    /**
     * @return void
     */
    public function testAutoSetAutoincrementNull(): void
    {
        $column = new Column(
            isPrimaryKey: false
        );

        $this->assertNull($column->getIsPKAutoIncrement());
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testNegativeMaximumLength(): void
    {
        $this->expectException(MaximumLengthException::class);
        new Column(maximumLength: -1);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testNegativeMinimumLength(): void
    {
        $this->expectException(MinimumLengthException::class);
        new Column(minimumLength: -1);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testMaximumLengthLessThanMinimumLength(): void
    {
        $this->expectException(MaximumLengthException::class);
        new Column(maximumLength: 4, minimumLength: 9);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testDecimalNegativeScale(): void
    {
        $this->expectException(DecimalScaleException::class);
        new Column(decimalScale: -1);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testDecimalZeroPrecision(): void
    {
        $this->expectException(DecimalPrecisionException::class);
        new Column(decimalPrecision: 0);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testSetterNegativeMaximumLength(): void
    {
        $this->expectException(MaximumLengthException::class);
        (new Column())->setMaximumLength(-1);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testSetterNegativeMinimumLength(): void
    {
        $this->expectException(MinimumLengthException::class);
        (new Column())->setMinimumLength(-1);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testSetterMaximumLengthLessThanMinimumLength(): void
    {
        $this->expectException(MaximumLengthException::class);
        (new Column())
            ->setMaximumLength(4)
            ->setMinimumLength(9);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testSetterMinimumLengthGraterThanMaximumLength(): void
    {
        $this->expectException(MaximumLengthException::class);
        (new Column())
            ->setMinimumLength(9)
            ->setMaximumLength(4);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testSetterDecimalNegativeScale(): void
    {
        $this->expectException(DecimalScaleException::class);
        (new Column())->setDecimalScale(-1);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     */
    public function testSetterDecimalZeroPrecision(): void
    {
        $this->expectException(DecimalPrecisionException::class);
        (new Column())->setDecimalPrecision(0);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\AttributesException
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testParseMyClass(): void
    {
        $reflectionClass = new \ReflectionClass(MyClass::class);
        $myTypeMap       = new MyTypeMap();
        $columns         = Column::parse($reflectionClass, $myTypeMap);

        $columnsNameAnType = [
            "columnString" => Types::DB_STRING,
            "columnInt" => Types::DB_INT,
            "columnFloat" => Types::DB_DECIMAL,
            "columnBool" => Types::DB_BOOLEAN,
            "columnDate" => Types::DB_DATE,
            "columnDecimal" => Types::DB_DECIMAL
        ];

        foreach ($columnsNameAnType as $name => $type) {
            $column = $columns[$name];
            $this->assertEquals($name, $column->getName());
            $this->assertFalse($column->getAllowNull());
            $this->assertSame($type, $column->getType());
        }

        $column = $columns["columnStringNull"];
        $this->assertEquals("columnStringNull", $column->getName());
        $this->assertTrue($column->getAllowNull());
        $this->assertSame(Types::DB_STRING, $column->getType());

        $this->assertTrue(
            Cache::instance()->cacheExist($reflectionClass)
        );

        $this->assertEquals(
            $columns,
            Column::parse($reflectionClass, $myTypeMap)
        );

        $mockCache = $this->createMock(ICache::class);

        $mockCache->expects($this->once())
            ->method("cacheExist")
            ->willReturn(true);

        $mockCache->expects($this->once())
            ->method("getFromCache")
            ->willReturn(\serialize($columns));

        Config::instance()->setDbCache($mockCache);

        $this->assertEquals(
            $columns,
            Column::parse($reflectionClass, $myTypeMap)
        );
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\AttributesException
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    public function testParseMyOtherClass(): void
    {
        $columns = Column::parse(new \ReflectionClass(MyOtherClass::class), new MyTypeMap());

        $columnsNameAnType = [
            "columnFloat" => Types::DB_DECIMAL,
            "columnBool" => Types::DB_BOOLEAN,
            "columnDate" => Types::DB_DATE,
        ];

        foreach ($columnsNameAnType as $name => $type) {
            $column = $columns[$name];
            $this->assertEquals($name, $column->getName());
            $this->assertFalse($column->getAllowNull());
            $this->assertSame($type, $column->getType());
        }

        $column = $columns["c_string"];
        $this->assertEquals("c_string", $column->getName());
        $this->assertFalse($column->getAllowNull());
        $this->assertSame(Types::DB_STRING, $column->getType());
        $this->assertSame(99, $column->getMaximumLength());
        $this->assertSame(9, $column->getMinimumLength());

        $column = $columns["c_int"];
        $this->assertEquals("c_int", $column->getName());
        $this->assertFalse($column->getAllowNull());
        $this->assertSame(Types::DB_TIMESTAMP, $column->getType());
        $this->assertSame(9999999, $column->getMaximum());
        $this->assertSame(0, $column->getMinimum());

        $column = $columns["c_decimal"];
        $this->assertEquals("c_decimal", $column->getName());
        $this->assertFalse($column->getAllowNull());
        $this->assertSame(Types::DB_DECIMAL, $column->getType());
        $this->assertSame(9, $column->getDecimalPrecision());
        $this->assertSame(2, $column->getDecimalScale());

        $column = $columns["columnStringNull"];
        $this->assertEquals("columnStringNull", $column->getName());
        $this->assertTrue($column->getAllowNull());
        $this->assertSame(Types::DB_STRING, $column->getType());
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testValidateValueFromInstancePropertyNotExist(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::PROPERTY_NAME_NOT_EXIST);

        $column = new Column();
        $column->setPropertyName("SomeProperty");

        $column->validate(new MyClass());
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testNullNotAllow(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::NULL_NOT_ALLOWED);

        $column = (new Column())->setAllowNull(false);
        $column->validate(null);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testStringMaximumLength(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::EXCEEDS_MAXIMUM_LENGTH);

        $column = new Column(maximumLength: 1);
        $column->validate("AA");
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testStringMinimumLength(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::LESS_THAN_MINIMUM_LENGTH);

        $column = new Column(minimumLength: 3);
        $column->validate("AA");
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testRegExp(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::FAIL_REGEXP);

        $column = new Column(regExp: "/^[0-9]$/");
        $column->validate("AA");
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testNumericGraterThan(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::VALUE_GRATER_THAN);

        $column = new Column(maximum: 9.9);
        $column->validate(9.999);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testNumericLessThan(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::VALUE_LESS_THAN);

        $column = new Column(minimum: 9.999);
        $column->validate(9.9);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testDecimalPrecisionThan(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::EXCEEDS_MAXIMUM_PRECISION);

        $column = new Column(decimalPrecision: 4);
        $column->validate(99.999);
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testDecimalScaleThan(): void
    {
        $this->expectException(ColumnValidateException::class);
        $this->expectExceptionCode(ColumnValidateException::EXCEEDS_MAXIMUM_SCALE);

        $column = new Column(decimalPrecision: 5, decimalScale: 2);
        $column->validate(99.999);
    }

    /**
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testValidateDecimal()
    {
        $this->expectNotToPerformAssertions();
        $column = new Column(maximum: 99.999, minimum: 9.9, decimalPrecision: 4, decimalScale: 2);
        $column->validate(99.99);
    }

    /**
     * @return void
     * @throws \PChouse\Attributes\Db\ColumnAttributeException
     * @throws \PChouse\Attributes\Db\ColumnValidateException
     */
    public function testValidateString()
    {
        $this->expectNotToPerformAssertions();
        $column = new Column(maximumLength: 3);
        $column->validate("AA");
    }
}
