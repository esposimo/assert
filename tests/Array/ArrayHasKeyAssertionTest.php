<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Array;

use Esposimo\Assertion\Array\ArrayHasKeyAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ArrayHasKeyAssertionTest extends TestCase
{
    /**
     * Fornisce una serie di casi di test per la validazione dell'uguaglianza.
     *
     * @return array<string, array{0: mixed, 1: mixed, 2: bool, 3: bool, 4: bool}>
     */
    public static function provideEqualData(): array
    {
        $data = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        ];
        return [
            // array, key, expectedResult
            'array_has_key' => [ $data, 'key1', true],
            'array_not_has_key' => [ $data, 'myKey', false],
        ];
    }

    #[Test]
    #[DataProvider('provideEqualData')]
    public function checkKeys(
        array $data,
        string $key,
        bool $expectedResult
    ): void
    {
        $assertion = new ArrayHasKeyAssertion($data, $key);
        $this->assertSame($expectedResult, $assertion->isValid());

        $not = new NotAssertion($assertion);
        $this->assertNotSame($expectedResult, $not->isValid());

    }
}
