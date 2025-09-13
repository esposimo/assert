<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * Verifies that the provided value is numeric.
 *
 * This class checks whether the given value is either a numeric type
 * (`int`, `float`, `double`) or represents a numeric value (e.g., a string
 * containing a number).
 *
 * The assertion can be configured to strictly validate numeric types only,
 * or to allow values that represent a number in string for
 */

class IsNumericAssertion extends AbstractAssert
{

    /**
     * Determines the check type
     *
     * When set to `true`, the check requires the value to be a numeric type.
     * When set to `false`, values representing numbers as strings are also allowed.
     *
     * @var bool
     */
    protected bool $strictCheck = false;

    /**
     * Configure the check type for assertion
     *
     * When set to `true`, the check requires the value to be a numeric type.
     * When set to `false`, values representing numbers as strings are also allowed.
     *
     * @param bool $strictCheck `true` for type check, ´false` values representing numbers as strings are also allowed.
     * @return $this
     *
     */
    public function setStrictCheck(bool $strictCheck): static
    {
        $this->strictCheck = $strictCheck;
        $this->check = null;
        return $this;
    }

    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = ($this->strictCheck) ?
            (is_int($this->firstOperand) || is_float($this->firstOperand)) :
            is_numeric($this->firstOperand);
    }
}

