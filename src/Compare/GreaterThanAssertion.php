<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Compare;

use Esposimo\Assertion\AbstractAssert;

/**
 * This class is an implementation of a simple assertion to verify if the first operand is greater than the second operand.
 *
 * <p>By default, the assertion checks for a strict greater-than condition (<b>firstOperand > secondOperand</b>).</p>
 *
 * <p>If you need an inclusive check (>=), you can enable this by calling the `setInclusive()` method.</p>
 *
 */

class GreaterThanAssertion extends AbstractAssert
{
    /**
     * Determines whether the range or assertion should be inclusive.
     *
     * @var bool $inclusive
     */
    private bool $inclusive = false;

    /**
     * Configures whether the assertion should be inclusive or exclusive.
     *
     * <p>
     * This method allows the user to define if the assertion should include equality in its comparison.
     * When the inclusivity flag is updated, the previously calculated assertion result is invalidated.
     * </p>
     *
     * @param bool $strict Determines the inclusivity of the assertion. A value of `true` sets the assertion to be inclusive,
     *                     while `false` sets it to be exclusive.
     * @return static Returns the current instance of the class, allowing method chaining for further configuration and assertions.
     */
    public function setInclusive(bool $strict): static
    {
        $this->inclusive = $strict;
        $this->check = null;
        return $this;
    }

    /**
     * Performs a custom assertion to compare the two operands configured in the class.
     *
     * <p>
     * This method evaluates the relationship between the operands (`$this->firstOperand` and `$this->secondOperand`).
     * It ensures that the assertion respects the context of whether the comparison is inclusive or exclusive.
     * </p>
     *
     * <ul>
     * <li>If either operand is a string, the assertion fails and return `false`.</li>
     * <li>If the comparison is inclusive, the method evaluates {@see $firstOperand} >= {@see $secondOperand} as the assertion condition.</li>
     * <li>If the comparison is not inclusive, the method evaluates {@see $firstOperand} > {@see $secondOperand} as the assertion condition.</li>
     * </ul>
     *
     * @return void The result of the assertion is stored internally in the {@see $check} property, and no value is directly returned.
     */
    protected function assert(): void
    {
        if ((is_string($this->firstOperand)) || (is_string($this->secondOperand)))
        {
            $this->check = false;
            return;
        }

        if ($this->inclusive) {
            $this->check = ($this->firstOperand >= $this->secondOperand);
        } else {
            $this->check = ($this->firstOperand > $this->secondOperand);
        }
    }
}

