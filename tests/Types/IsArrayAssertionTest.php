<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Types;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsArrayAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(IsArrayAssertion::class)]
class IsArrayAssertionTest extends TestCase
{
    #[Test]
    public function check_if_is_array(): void
    {
        $data = "";
        $check = new IsArrayAssertion($data);
        $this->assertFalse($check->isValid());
        $this->assertTrue((new NotAssertion($check))->isValid());


        $data = array();
        $check = new IsArrayAssertion($data);
        $this->assertTrue($check->isValid());
        $this->assertFalse((new NotAssertion($check))->isValid());

        $data = [];
        $check = new IsArrayAssertion($data);
        $this->assertTrue($check->isValid());
        $this->assertFalse((new NotAssertion($check))->isValid());

        $data = array(1,2,3);
        $check = new IsArrayAssertion($data);
        $this->assertTrue($check->isValid());
        $this->assertFalse((new NotAssertion($check))->isValid());

        $data = [1,2,3];
        $check = new IsArrayAssertion($data);
        $this->assertTrue($check->isValid());
        $this->assertFalse((new NotAssertion($check))->isValid());

        $data = "string";
        $check = new IsArrayAssertion($data);
        $this->assertFalse($check->isValid());
        $this->assertTrue((new NotAssertion($check))->isValid());

        $data = 10;
        $check = new IsArrayAssertion($data);
        $this->assertFalse($check->isValid());
        $this->assertTrue((new NotAssertion($check))->isValid());

        $data = 10.3;
        $check = new IsArrayAssertion($data);
        $this->assertFalse($check->isValid());
        $this->assertTrue((new NotAssertion($check))->isValid());

        $data = true;
        $check = new IsArrayAssertion($data);
        $this->assertFalse($check->isValid());
        $this->assertTrue((new NotAssertion($check))->isValid());

        $data = new stdClass();
        $check = new IsArrayAssertion($data);
        $this->assertFalse($check->isValid());
        $this->assertTrue((new NotAssertion($check))->isValid());

    }

}

