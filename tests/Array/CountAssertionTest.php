<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Array;

use Esposimo\Assertion\Array\CountAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CountAssertionTest extends TestCase
{
    /**
     * Fornisce una serie di casi di test per la validazione dell'uguaglianza.
     *
     * @return array<string, array{0: mixed, 1: mixed, 2: bool, 3: bool, 4: bool}>
     */
    public static function provideEqualData(): array
    {
        return [
            // Descrizione del caso => [primo, secondo, strict?, caseSensitive?, risultato atteso]
            'equal_case' => [[1,2,3], 3, true],
            'not_equal_case' => [[1,2,3], 1, false],
        ];
    }


    public static function provideLessThanData() : array
    {
        // data, count, inclusive, expectedValue
        return [
            'less_than_no_inclusive' => [[1,2,3], 4, false, true],
            'less_than_inclusive' => [[1,2,3], 4, true, true],
            'less_than_equal_no_inclusive' => [[1,2,3], 3, false, false],
            'less_than_equal_inclusive' => [[1,2,3], 3, true, true]
        ];
    }

    public static function provideGreaterThanData() : array
    {
        // data, count, inclusive, expectedValue
        return [
            'greater_than_no_inclusive' => [[1,2,3], 2, false, true],
            'greater_than_inclusive' => [[1,2,3], 2, true, true],
            'greater_than_equal_no_inclusive' => [[1,2,3], 3, false, false],
            'greater_than_equal_inclusive' => [[1,2,3], 3, true, true]
        ];
    }

    public static function provideRangeData() : array
    {
        // data, min, max, minInclusive, maxInclusive, expectedValue
        return [
            'range_no_inclusive' => [[1,2,3,4,5], 0, 5, false, false, false],
            'range_min_no_inclusive' => [[1,2,3,4,5], 0, 5, false, true, true],
            'range_max_no_inclusive' => [[1,2,3,4,5], 0, 5, true, false, false],
            'range_inclusive' => [[1,2,3,4,5], 0, 5, true, true, true],
            'min_range_no_inclusive' => [[1,2,3,4,5], 1, 5, false, false, false],
            'min_min_range_no_inclusive' => [[1,2,3,4,5], 1, 5, false, true, true],
            'min_max_range_no_inclusive' => [[1,2,3,4,5], 1, 5, true, false, false],
            'min_range_inclusive' => [[1,2,3,4,5], 1, 5, true, true, true],
            'max_range_no_inclusive' => [[1,2,3,4,5], 0, 6, false, false, true],
            'max_min_range_no_inclusive' => [[1,2,3,4,5], 0, 6, true, false, true],
            'max_max_range_no_inclusive' => [[1,2,3,4,5], 1, 6, false, true, true],
            'max_range_inclusive' => [[1,2,3,4,5], 0, 6, true, true, true],
            'wrong_range_no_inclusive' => [[1,2,3,4,5], 10, 15, false, false, false],
            'wrong_range_min_inclusive' => [[1,2,3,4,5], 10, 10, true, false, false],
            'wrong_range_max_inclusive' => [[1,2,3,4,5], 10, 10, false, true, false],
            'wrong_range_inclusive' => [[1,2,3,4,5], 10, 10, true, true, false]
        ];
    }

    #[Test]
    #[DataProvider('provideEqualData')]
    public function check_equal_cases(array $data, int $count, bool $expectedResult): void
    {
        $assertion = new CountAssertion($data, $count);
        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());
    }

    #[Test]
    #[DataProvider('provideLessThanData')]
    public function check_less_cases(array $data, int $count, bool $inclusive, bool $expectedResult): void
    {
        $assertion = new CountAssertion($data, $count);
        $assertion->useLessThanCompare($inclusive);
        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());
    }

    #[Test]
    #[DataProvider('provideGreaterThanData')]
    public function check_greater_cases(array $data, int $count, bool $inclusive, bool $expectedResult): void
    {
        $assertion = new CountAssertion($data, $count);
        $assertion->useGreaterThanCompare($inclusive);
        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());
    }

    #[Test]
    #[DataProvider('provideRangeData')]
    public function check_range_cases(
        array $data,
        int $min,
        int $max,
        bool $minInclusive,
        bool $maxInclusive,
        bool $expectedResult
    ): void
    {
        // data, min, max, minInclusive, maxInclusive, expectedValue
        $assertion = new CountAssertion($data);
        $assertion->useInRangeCompare($min, $max, $minInclusive, $maxInclusive);
        $this->assertSame($expectedResult, $assertion->isValid());

        $this->assertNotSame($expectedResult, (new NotAssertion($assertion))->isValid());
    }
}
