<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Array;

use Esposimo\Assertion\Array\ArrayContainsAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ArrayContainsAssertionTest extends TestCase
{
    /**
     * Fornisce una serie di casi di test per la validazione dell'uguaglianza.
     *
     * @return array<string, array{0: mixed, 1: mixed, 2: bool, 3: bool, 4: bool}>
     */
    public static function provideData(): array
    {
        $data = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 4,
            'key5' => "5"
        ];
        return [
            // array, key, strict, expectedResult
            'array_has_value_strict' => [ $data, 'value1', false, true],
            'array_has_value_no_strict' => [ $data, 'value1', true, true],
            'array_has_int_strict' => [ $data, 4, false, true],
            'array_has_int_no_strict' => [ $data, 4, true, true],
            'array_has_int_string_strict' => [ $data, "5", false, true],
            'array_has_int_string_no_strict' => [ $data, "5", true, true],
            'array_has_int_passed_with_string_no_strict' => [ $data, "4", false, true],
            'array_has_int_passed_with_string_strict' => [ $data, "4", true, false],
        ];
    }

    #[Test]
    #[DataProvider('provideData')]
    public function checkValues(
        array $data,
        mixed $value,
        bool $strict,
        bool $expectedResult
    ): void
    {
        $assertion = new ArrayContainsAssertion($data, $value);
        $assertion->setStrict($strict);
        $this->assertSame($expectedResult, $assertion->isValid());

        $not = new NotAssertion($assertion);
        $this->assertNotSame($expectedResult, $not->isValid());
    }
}
