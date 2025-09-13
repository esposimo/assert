<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Types;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsInstanceAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(IsInstanceAssertion::class)]


class A {

}

class B extends A {

}

class IsInstanceAssertionTest extends TestCase
{

    public static function provideDataTest(): array
    {
        return [
            // Descrizione del caso => [oggetto, confronto, risultato atteso]
            'base_class_compare' => [new \Esposimo\Assertion\Tests\Types\A(), \Esposimo\Assertion\Tests\Types\A::class, true],
            'different_class' => [new \Esposimo\Assertion\Tests\Types\A(), \Esposimo\Assertion\Tests\Types\B::class, false],
            'extended_class' => [new \Esposimo\Assertion\Tests\Types\B(), \Esposimo\Assertion\Tests\Types\B::class, true],
            'extended_base_class' => [new \Esposimo\Assertion\Tests\Types\B(), \Esposimo\Assertion\Tests\Types\A::class, true]
        ];
    }

    #[Test]
    #[DataProvider('provideDataTest')]
    public function check_if_is_instance(mixed $object, mixed $compare, bool $expectedResult): void
    {
        $instance = new IsInstanceAssertion($object, $compare);
        $this->assertSame($expectedResult, $instance->isValid());
        $this->assertNotSame($expectedResult, (new NotAssertion($instance))->isValid());
    }

}

