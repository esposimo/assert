<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Types;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsNotNullAssertion;
use Esposimo\Assertion\Types\IsNullAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(IsNullAssertion::class)]

class IsNotNullAssertionTest extends TestCase
{
    public static function provideDataTest(): array
    {
    return [
        // Descrizione del caso => [oggetto, confronto, risultato atteso]
        'text_compare' => ["string", true],
        'number_compare' => [10, true],
        'boolean_compare' => [false, true],
        'null_compare' => [null, false]
    ];
}

    #[Test]
    #[DataProvider('provideDataTest')]
    public function check_null(mixed $compare, bool $expectedResult): void
    {
        $instance = new IsNotNullAssertion($compare);
        $this->assertSame($expectedResult, $instance->isValid(null));
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }
}

