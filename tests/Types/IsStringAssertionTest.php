<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests\Types;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsStringAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractConjunction::class)]
#[CoversClass(IsStringAssertion::class)]
class IsStringAssertionTest extends TestCase
{
    #[Test]
    public function check_empty_string(): void
    {
        $string = "";
        $isString = new IsStringAssertion($string);
        $this->assertFalse($isString->isValid());
        $isString->setEmptyStringCheck(true);
        $this->assertTrue($isString->isValid());
        $this->assertFalse((new NotAssertion($isString))->isValid());
    }

    #[Test]
    public function check_no_empty_string(): void
    {
        $string = "string to test";
        $isString = new IsStringAssertion($string);
        $this->assertTrue($isString->isValid());
        $isString->setEmptyStringCheck(true);
        $this->assertTrue($isString->isValid());
        $this->assertFalse((new NotAssertion($isString))->isValid());
    }
}

