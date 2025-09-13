<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Strings;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Strings\StringEndsWithAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(StringEndsWithAssertion::class)]
class StringEndsWithAssertionTest extends TestCase
{
    public static function dataProviderSetCaseSensitive(): array
    {
        return [
            'start_with_case_sensitive_enable' => [ 'Ciao Mondo', 'Mondo', true, true ],
            'start_with_case_sensitive_disable' => [ 'Ciao Mondo', 'Mondo', false, true ],
            'i_contains_with_case_sensitive_enable' => [ 'Ciao Mondo', 'mondo', true, false ],
            'i_contains_with_case_sensitive_disable' => [ 'Ciao Mondo', 'mondo', false, true ],
            'no_contains_case_sensitive_enable' => ['Ciao Mondo', 'foobar', true, false],
            'no_contains_case_sensitive_disable' => ['Ciao Mondo', 'foobar', false, false]
        ];
    }

    #[Test]
    #[DataProvider('dataProviderSetCaseSensitive')]
    public function checkStringContains(string $stack, string $need, bool $caseSensitive, bool $expectedResult) : void
    {
        $instance = new StringEndsWithAssertion($stack, $need);
        $instance->setCaseSensitive($caseSensitive);
        $this->assertSame($expectedResult, $instance->isValid());
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }

}

