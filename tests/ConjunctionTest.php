<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Tests;

use Esposimo\Assertion\AbstractConjunction;
use Esposimo\Assertion\AndConjunction;
use Esposimo\Assertion\AssertableInterface;
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\OrConjunction;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AndConjunction::class)]
#[CoversClass(OrConjunction::class)]
#[CoversClass(AbstractConjunction::class)]
class ConjunctionTest extends TestCase
{
    #[Test]
    public function and_conjunction_is_true_only_if_all_assertions_are_true(): void
    {
        $trueAssertion = $this->createStub(AssertableInterface::class);
        $trueAssertion->method('isValid')->willReturn(true);

        $falseAssertion = $this->createStub(AssertableInterface::class);
        $falseAssertion->method('isValid')->willReturn(false);

        $this->assertTrue((new AndConjunction([$trueAssertion, $trueAssertion]))->isValid());
        $this->assertFalse((new AndConjunction([$trueAssertion, $falseAssertion]))->isValid());

        $this->assertFalse((new NotAssertion(new AndConjunction([$trueAssertion, $trueAssertion])))->isValid());
        $this->assertTrue((new NotAssertion(new AndConjunction([$trueAssertion, $falseAssertion])))->isValid());

    }

    #[Test]
    public function or_conjunction_is_true_if_at_least_one_assertion_is_true(): void
    {
        $trueAssertion = $this->createStub(AssertableInterface::class);
        $trueAssertion->method('isValid')->willReturn(true);

        $falseAssertion = $this->createStub(AssertableInterface::class);
        $falseAssertion->method('isValid')->willReturn(false);

        $this->assertTrue((new OrConjunction([$trueAssertion, $falseAssertion]))->isValid());
        $this->assertFalse((new OrConjunction([$falseAssertion, $falseAssertion]))->isValid());

        $this->assertFalse((new NotAssertion(new OrConjunction([$trueAssertion, $falseAssertion])))->isValid());
        $this->assertTrue((new NotAssertion(new OrConjunction([$falseAssertion, $falseAssertion])))->isValid());
    }

    #[Test]
    public function it_correctly_evaluates_nested_conjunctions(): void
    {
        $true = $this->createStub(AssertableInterface::class);
        $true->method('isValid')->willReturn(true);

        $false = $this->createStub(AssertableInterface::class);
        $false->method('isValid')->willReturn(false);

        // (true AND (false OR true)) => true
        $orGroup = new OrConjunction([$false, $true]); // -> true
        $finalAssertion = new AndConjunction([$true, $orGroup]);

        $this->assertTrue($finalAssertion->isValid());
        $this->assertFalse((new NotAssertion($finalAssertion))->isValid());

    }
}

