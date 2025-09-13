<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Types;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsIntAssertion;
use Esposimo\Assertion\Types\IsNumericAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(IsNumericAssertion::class)]
#[CoversClass(IsIntAssertion::class)]
class IsIntAssertionTest extends TestCase
{
    #[Test]
    public function check_int_representation_and_type(): void
    {
        $value = 10;
        $assert = new IsIntAssertion($value);
        $this->assertTrue($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertTrue($assert->isValid());
        $this->assertFalse((new NotAssertion($assert))->isValid());

        $value = "15";
        $assert = new IsIntAssertion($value);
        $this->assertTrue($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());
    }

    #[Test]
    public function check_float_representation_and_type(): void
    {
        $value = 10.3;
        $assert = new IsIntAssertion($value);
        $this->assertFalse($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());

        $value = "15.3";
        $assert = new IsIntAssertion($value);
        $this->assertFalse($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());
    }

    #[Test]
    public function check_on_other_no_numeric_types() : void
    {
        $value = "string";
        $assert = new IsIntAssertion($value);
        $this->assertFalse($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());

        $value = array(1, 2, 3);
        $assert = new IsIntAssertion($value);
        $this->assertFalse($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());

        $value = null;
        $assert = new IsIntAssertion($value);
        $this->assertFalse($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());


        $value = false;
        $assert = new IsIntAssertion($value);
        $this->assertFalse($assert->isValid());
        $assert->setStrictCheck(true);
        $this->assertFalse($assert->isValid());
        $this->assertTrue((new NotAssertion($assert))->isValid());

    }
}

