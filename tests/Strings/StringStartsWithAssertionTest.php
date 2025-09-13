<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Strings;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Strings\StringStartsWithAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(StringStartsWithAssertion::class)]
class StringStartsWithAssertionTest extends TestCase
{
    public static function dataProviderSetCaseSensitive(): array
    {
        // stack, needle, caseSensitive, expectedResult
        // Ciao Mondo , Mondo con case sensitive e insensitive
        // Ciao Mondo, mondo con case sensitive e insensitive
        // Ciao Mondo, foobar

        return [
            'start_with_case_sensitive_enable' => [ 'Ciao Mondo', 'Ciao', true, true ],
            'start_with_case_sensitive_disable' => [ 'Ciao Mondo', 'Ciao', false, true ],
            'i_contains_with_case_sensitive_enable' => [ 'Ciao Mondo', 'ciao', true, false ],
            'i_contains_with_case_sensitive_disable' => [ 'Ciao Mondo', 'ciao', false, true ],
            'no_contains_case_sensitive_enable' => ['Ciao Mondo', 'foobar', true, false],
            'no_contains_case_sensitive_disable' => ['Ciao Mondo', 'foobar', false, false],
        ];
    }

    #[Test]
    #[DataProvider('dataProviderSetCaseSensitive')]
    public function checkStringStarts(string $stack, string $need, bool $caseSensitive, bool $expectedResult) : void
    {
        $instance = new StringStartsWithAssertion($stack, $need);
        $instance->setCaseSensitive($caseSensitive);
        $this->assertSame($expectedResult, $instance->isValid());
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }

}

