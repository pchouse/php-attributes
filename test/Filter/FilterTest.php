<?php
declare(strict_types=1);

namespace PChouse\Filter;

use PChouse\Attributes\Config\Config;
use PChouse\Attributes\Filter\Filter;
use PChouse\Attributes\Filter\FilterException;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /**
     * @return void
     * @throws \PChouse\Attributes\HTML\Cache\HtmlCacheException
     */
    #[Before]
    public static function beforeEach(): void
    {
        Config::instance()->getFilterCache()?->clearCache();
    }

    #[Test]
    public function testDefaultInstance(): void
    {
        $filter = new Filter([FILTER_DEFAULT]);

        $this->assertSame([FILTER_DEFAULT], $filter->getFilterId());
        $this->assertSame(FILTER_NULL_ON_FAILURE, $filter->getOptions());
        $this->assertTrue($filter->getTrim());
        $this->assertNull($filter->getName());
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function testTrim(): void
    {
        $filter = new Filter([FILTER_DEFAULT]);
        $string = "AAA ";

        assert(\str_ends_with($string, " "));

        $this->assertSame(\trim($string), $filter->filter($string));
        $filter->setTrim(false);
        $this->assertSame($string, $filter->filter($string));

    }

    /**
     * @return void
     */
    #[Test]
    public function testGetterSetter(): void
    {
        $name   = "prop";
        $filter = new Filter([FILTER_DEFAULT], [], false, $name);

        $this->assertSame([FILTER_DEFAULT], $filter->getFilterId());
        $this->assertSame(["flags" => FILTER_NULL_ON_FAILURE], $filter->getOptions());
        $this->assertSame($name, $filter->getName());
        $this->assertFalse($filter->getTrim());

        $filter->setFilterId([FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL]);
        $this->assertSame([FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL], $filter->getFilterId());

        $filter->setOptions(FILE_IGNORE_NEW_LINES);
        /** @phpstan-ignore-next-line */
        $this->assertTrue(($filter->getOptions() & FILE_IGNORE_NEW_LINES) === FILE_IGNORE_NEW_LINES);
        /** @phpstan-ignore-next-line */
        $this->assertTrue(($filter->getOptions() & FILTER_NULL_ON_FAILURE) === FILTER_NULL_ON_FAILURE);

        $filter->setOptions(["default" => FILE_IGNORE_NEW_LINES]);
        /** @phpstan-ignore-next-line */
        $this->assertSame(FILE_IGNORE_NEW_LINES, $filter->getOptions()["default"]);
        $this->assertTrue(($filter->getOptions()["flags"] & FILTER_NULL_ON_FAILURE) === FILTER_NULL_ON_FAILURE);

        foreach ([true, false] as $bool) {
            $filter->setTrim($bool);
            $this->assertSame($bool, $filter->getTrim());
        }

        $filter->setName("Other");
        $this->assertSame("Other", $filter->getName());

    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function testFilter(): void
    {
        $filter = new Filter([FILTER_SANITIZE_EMAIL]);
        $this->assertSame(
            "rebelo.han-joo@koryo.kr",
            $filter->filter("rebelo\t.han-joo@koryo.kr")
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function testFailFilter(): void
    {
        $this->expectException(FilterException::class);
        $filter = new Filter([FILTER_VALIDATE_EMAIL]);
        $filter->filter("rebelo\t.han-joo@koryo.kr");
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function testSanitizeAndFilter(): void
    {
        $filter = new Filter(
            [FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL]
        );

        $this->assertSame(
            "rebelo.han-joo@koryo.kr",
            $filter->filter("rebelo\t.han-joo@koryo.kr")
        );
    }

}