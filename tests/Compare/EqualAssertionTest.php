<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Compare;

use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EqualAssertionTest extends TestCase
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
            'strict_equal_integers' => [5, 5, true, true, true],
            'strict_unequal_types' => [5, '5', true, true, false],
            'loose_equal_types' => [5, '5', false, true, true],
            'strict_equal_strings' => ['hello', 'hello', true, true, true],
            'strict_unequal_case' => ['Hello', 'hello', true, true, false],
            'case_insensitive_equal' => ['Hello', 'hello', true, false, true],
            'case_insensitive_loose' => ['123', 123, false, false, true], // strcasecmp converte int in string
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
        $assertion = (new EqualAssertion($first, $second))
            ->setStrict($isStrict)
            ->setCaseSensitive($isCaseSensitive);

        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());

    }
}
