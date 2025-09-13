<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Strings;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Strings\RegexAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(RegexAssertion::class)]
class RegexAssertionTest extends TestCase
{
    public static function dataProviderNoGroup(): array
    {
        return [
            'regex_capture' => [ 'Ciao Mondo', '/Mondo/', true],
            'regex_not_capture'  => ['Ciao Mondo', '/foobar/', false],
            'regex_with_group' => ['Ciao Mondo', '/Ciao .*/', true],
            'regex_not_capture_with_group' => ['Ciao Mondo', '/Hello World/', false]
        ];
    }

    public static function dataProviderWithGroup(): array
    {
        return [
            'regex_capture' => ['Ciao Mondo', '/(\w+) Mondo/', 2, true]
        ];
    }

    #[Test]
    #[DataProvider('dataProviderNoGroup')]
    public function checkRegex(string $subject, string $pattern, bool $expectedResult) : void
    {
        $instance = new RegexAssertion($pattern, $subject);
        $this->assertSame($expectedResult, $instance->isValid());
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }

    #[Test]
    #[DataProvider('dataProviderWithGroup')]
    public function checkRegexGroup(string $subject, string $pattern, int $countMatched, bool $expectedResult) : void
    {
        $instance = new RegexAssertion($pattern, $subject);
        $this->assertSame($expectedResult, $instance->isValid());
        $this->assertCount($countMatched, $instance->getCapturedMatches());
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }

}

