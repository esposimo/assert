<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Compare;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\AndConjunction;
use Esposimo\Assertion\Compare\GreaterThanAssertion;
use Esposimo\Assertion\Compare\InRangeAssertion;
use Esposimo\Assertion\Compare\LessThanAssertion;
use Esposimo\Assertion\NotAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AndConjunction::class)]
#[CoversClass(AbstractConjunction::class)]
#[CoversClass(InRangeAssertion::class)]
#[CoversClass(GreaterThanAssertion::class)]
#[CoversClass(LessThanAssertion::class)]
class InRangeAssertionTest extends TestCase
{
    #[Test]
    public function between_with_no_inclusive(): void
    {
        $between = new InRangeAssertion(13, 10,15);
        $between->setInclusive(false, false);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());


        $between = new InRangeAssertion(15, 10, 15);
        $between->setInclusive(false, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());


        $between = new InRangeAssertion(10, 10, 15);
        $between->setInclusive(false, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(20, 10, 15);
        $between->setInclusive(false, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(2, 10, 15);
        $between->setInclusive(false, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

    }

    #[Test]
    public function between_with_inclusive_left_and_right(): void
    {
        $between = new InRangeAssertion(13, 10,15);
        $between->setInclusive(true, true);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(15, 10, 15);
        $between->setInclusive(true, true);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(10, 10, 15);
        $between->setInclusive(true, true);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(20, 10, 15);
        $between->setInclusive(true, true);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(2, 10, 15);
        $between->setInclusive(true, true);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

    }

    #[Test]
    public function between_with_inclusive_left(): void
    {
        $between = new InRangeAssertion(13, 10,15);
        $between->setInclusive(true, false);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(15, 10, 15);
        $between->setInclusive(true, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(10, 10, 15);
        $between->setInclusive(true, false);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(20, 10, 15);
        $between->setInclusive(true, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(2, 10, 15);
        $between->setInclusive(true, false);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

    }

    #[Test]
    public function between_with_inclusive_right(): void
    {
        $between = new InRangeAssertion(13, 10,15);
        $between->setInclusive(false, true);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(15, 10, 15);
        $between->setInclusive(false, true);
        $this->assertTrue($between->isValid());
        $this->assertFalse((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(10, 10, 15);
        $between->setInclusive(false, true);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(20, 10, 15);
        $between->setInclusive(false, true);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

        $between = new InRangeAssertion(2, 10, 15);
        $between->setInclusive(false, true);
        $this->assertFalse($between->isValid());
        $this->assertTrue((new NotAssertion($between))->isValid());

    }
}

