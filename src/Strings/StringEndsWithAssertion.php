<?php

namespace Esposimo\Assertion\Strings;

use Esposimo\Assertion\AbstractAssert;

/**
 * Class StringEndsWithAssertion
 *
 * <p>This class provides functionality to check whether a given string
 * ends with another string (the "second operand").</p>
 *
 * <p>It allows configuring case sensitivity for the assertion. By default, the assertion is case-insensitive,
 * but it can be made case-sensitive by using the {@see setCaseSensitive()} method.</p>
 *
 * <p>This class is part of a simple assertion library designed to perform various types of assertions
 * with a flexible and extensible approach.</p>
 */
class StringEndsWithAssertion extends AbstractAssert
{

    /**
     * @var bool $caseSensitive
     *
     * <p>Defines whether the assertion checks should be case-sensitive or not.</p>
     * <p>By default, this value is set to <code>false</code>, meaning the checks are case-insensitive.</p>
     */
    protected bool $caseSensitive = false;

    /**
     * Sets the case sensitivity for the assertion checks.
     *
     * <p>This method configures whether the checks performed by the assertion
     * should be case-sensitive or not. If case sensitivity is disabled,
     * string comparisons will be performed in a case-insensitive manner.</p>
     *
     * <lu>
     * <li>Updates the internal case sensitivity configuration.</li>
     * <li>Resets the result of the last check to null.</li>
     * </lu>
     *
     * @param bool $caseSensitive A boolean value indicating whether the assertion checks
     *                            should consider case sensitivity (true for case-sensitive,
     *                            false for case-insensitive).
     * @return static Returns an instance of the current object to allow method chaining.
     */
    public function setCaseSensitive(bool $caseSensitive): static
    {
        $this->caseSensitive = $caseSensitive;
        $this->check = null;
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        $stack = $this->firstOperand;;
        $need = $this->secondOperand;
        if ($this->caseSensitive === false) {
            $stack = strtolower($this->firstOperand);
            $need = strtolower($this->secondOperand);
        }
        $this->check = str_ends_with($stack, $need);
    }
}