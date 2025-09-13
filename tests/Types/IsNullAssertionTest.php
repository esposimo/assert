<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Types;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsNullAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(IsNullAssertion::class)]

class IsNullAssertionTest extends TestCase
{
    public static function provideDataTest(): array
    {
    return [
        // Descrizione del caso => [oggetto, confronto, risultato atteso]
        'text_compare' => ["string", false],
        'number_compare' => [10, false],
        'boolean_compare' => [false, false],
        'null_compare' => [null, true]
    ];
}

    #[Test]
    #[DataProvider('provideDataTest')]
    public function check_null(mixed $compare, bool $expectedResult): void
    {
        $instance = new IsNullAssertion($compare);
        $this->assertSame($expectedResult, $instance->isValid(null));
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }
}

