<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Compare;

use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\Compare\LessThanAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LessThanAssertionTest extends TestCase
{
    /**
     * Fornisce una serie di casi di test per la validazione dell'uguaglianza.
     * 3 < 4
     * 3 <= 4
     * 3 < 3
     * 3 <= 3
     * @return array<string, array{0: mixed, 1: mixed, 2: bool, 3: bool, 4: bool}>
     */
    public static function provideLessThanEquality(): array
    {
        return [
            // Descrizione del caso => primo, secondo, include, expectedResult
            'less_than_with_include' => [3, 4, false, true],
            'less_than_with_no_include' => [3, 4, true, true],
            'less_than_equal_with_include' => [3, 3, false, false],
            'less_than_equal_with_no_include' => [3, 3, true, true],
        ];
    }

    #[Test]
    #[DataProvider('provideLessThanEquality')]
    public function check_less_Equality(
        mixed $first,
        mixed $second,
        bool $inclusive,
        bool $expectedResult
    ): void {
        $assertion = (new LessThanAssertion($first, $second))
            ->setInclusive($inclusive);

        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());

    }
}
