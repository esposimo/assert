<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Compare;

use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\Compare\NotEqualAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NotEqualAssertionTest extends TestCase
{
    /**
     * Fornisce una serie di casi di test per la validazione dell'uguaglianza.
     *
     * @return array<string, array{0: mixed, 1: mixed, 2: bool, 3: bool, 4: bool}>
     */
    public static function provideEqualityCases(): array
    {
        return [
            // Descrizione del caso => [primo, secondo, strict?, caseSensitive?, risultato atteso]
            'strict_equal_integers' => [5, 6, true, true, true],
            'strict_unequal_types' => [5, '6', true, true, true],
            'loose_equal_types' => [5, '6', false, true, true],
            'strict_equal_strings' => ['hello', 'hellos', true, true, true],
            'strict_unequal_case' => ['Hello', 'hellos', true, true, true],
            'case_insensitive_equal' => ['Hello', 'hellos', true, false, true],
            'case_insensitive_loose' => ['123', 1234, false, false, true], // strcasecmp converte int in string
        ];
    }

    #[DataProvider('provideEqualityCases')]
    public function testAssertionBehavesAsExpected(
        mixed $first,
        mixed $second,
        bool $isStrict,
        bool $isCaseSensitive,
        bool $expectedResult
    ): void {
        $assertion = (new NotEqualAssertion($first, $second))
            ->setStrict($isStrict)
            ->setCaseSensitive($isCaseSensitive);

        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());

    }
}
