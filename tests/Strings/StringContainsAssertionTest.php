<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Strings;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Strings\StringContainsAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(StringContainsAssertion::class)]
class StringContainsAssertionTest extends TestCase
{
    public static function dataProviderSetCaseSensitive(): array
    {
        // stack, needle, caseSensitive, expectedResult
        // Ciao Mondo , Mondo con case sensitive e insensitive
        // Ciao Mondo, mondo con case sensitive e insensitive
        // Ciao Mondo, foobar

        return [
            'contains_with_case_sensitive_enable' => [ 'Ciao Mondo', 'Mondo', true, true ],
            'contains_with_case_sensitive_disable' => [ 'Ciao Mondo', 'Mondo', false, true ],
            'i_contains_with_case_sensitive_enable' => [ 'Ciao Mondo', 'mondo', true, false ],
            'i_contains_with_case_sensitive_disable' => [ 'Ciao Mondo', 'mondo', false, true ],
            'no_contains_case_sensitive_enable' => ['Ciao Mondo', 'foobar', true, false],
            'no_contains_case_sensitive_disable' => ['Ciao Mondo', 'foobar', false, false],
        ];
    }

    public static function dataProviderSetCaseInSensitive(): array
    {
        // stack, needle, expectedResult
        return [
            'contain_case_sensitive' => [ 'Ciao Mondo', 'Mondo', true ],
            'contains_case_insensitive' => [ 'Ciao Mondo', 'mondo', false ]
        ];
    }

    #[Test]
    #[DataProvider('dataProviderSetCaseSensitive')]
    public function checkStringContains(string $stack, string $need, bool $caseSensitive, bool $expectedResult) : void
    {
        $instance = new StringContainsAssertion($stack, $need);
        $instance->setCaseSensitive($caseSensitive);
        $this->assertSame($expectedResult, $instance->isValid());
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }

}

