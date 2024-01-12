<?php
declare(strict_types=1);

namespace PChouse\Db;

use PChouse\Attributes\Db\Table;
use PChouse\Resources\MyClass;
use PChouse\Resources\MyOtherClass;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function testInstanceNoArguments(): void
    {
        $tableName = "TableName";
        $table     = new Table();

        $this->assertNull($table->getName());
        $this->assertFalse($table->getIsView());

        $table->setName($tableName);
        $table->setIsView(true);

        $this->assertEquals($tableName, $table->getName());
        $this->assertTrue($table->getIsView());
    }

    /**
     * @test
     * @return void
     */
    public function testInstanceWithArguments(): void
    {
        $tableName = "TableName";

        foreach ([true, false] as $bool) {
            $table = new Table(name: $tableName, isView: $bool);
            $this->assertEquals($tableName, $table->getName());
            $this->assertEquals($bool, $table->getIsView());
        }
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\TableAttributeException
     */
    public function testParseNoArguments(): void
    {
        $table = Table::parse(new \ReflectionClass(MyClass::class));
        $this->assertEquals("MyClass", $table->getName());
        $this->assertFalse($table->getIsView());
    }

    /**
     * @test
     * @return void
     * @throws \PChouse\Attributes\Db\TableAttributeException
     */
    public function testParseWithArguments(): void
    {
        $table = Table::parse(new \ReflectionClass(MyOtherClass::class));
        $this->assertEquals("my_table", $table->getName());
        $this->assertTrue($table->getIsView());
    }
}
