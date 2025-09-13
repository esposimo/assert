<?php

namespace Esposimo\Assertion\Array;

use Esposimo\Assertion\AbstractAssert;
use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\Compare\GreaterThanAssertion;
use Esposimo\Assertion\Compare\InRangeAssertion;
use Esposimo\Assertion\Compare\LessThanAssertion;

/**
 * Class ArrayContainsAssertion
 *
 * This class performs an assertion to check whether an array (first operand) contains a specified value (second operand).
 *
 * <p>The assertion can be performed in either a strict or non-strict manner:
 *    <ul>
 *        <li>In strict mode, the types of the values will also be compared.</li>
 *        <li>In non-strict mode, type comparisons will be ignored during the check.</li>
 *    </ul>
 * </p>
 */
class ArrayContainsAssertion extends AbstractAssert
{

    /**
     * @var bool $strict
     *
     * <p>This property determines whether assertions should be performed in strict mode.</p>
     * <p>When <code>$strict</code> is set to <code>true</code>, the assertions will enforce stricter evaluation,
     * such as using type-sensitive comparisons in equality checks.
     * If set to <code>false</code>, looser, more lenient checks will be applied.</p>
     *
     * <p>Default value: <code>false</code></p>
     */
    protected bool $strict = false;

    /**
     * Sets the strict mode for the assertion comparison.
     *
     * <p>When strict mode is enabled, the assertion comparison will consider not
     * only the value but also the data type of the operands.</p>
     *
     * <p>When strict mode is disabled, only the value will be considered during
     * the assertion comparison.</p>
     *
     * <p>This method resets the current check result to null.</p>
     *
     * @param bool $strict Whether to enable (true) or disable (false) strict mode for comparisons.
     *
     * @return static Provides a fluent interface allowing method chaining.
     */
    public function setStrict(bool $strict): static
    {
        $this->strict = $strict;
        $this->check = null;
        return $this;
    }
    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        $this->check = in_array($this->secondOperand, $this->firstOperand, $this->strict);
    }
}