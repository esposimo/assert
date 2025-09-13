<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;


/**
 * Verifies that the provided value is a int number.
 *
 * This class checks whether the given value is either a int type
 * or represents a numeric value (e.g., a string containing a int number).
 *
 * The assertion can be configured to strictly validate numeric types only,
 * or to allow values that represent a number in string for
 *
 * This class is an extension of {@see IsNumericAssertion}
 */

class IsIntAssertion extends IsNumericAssertion
{
    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = ($this->strictCheck) ?
            is_int($this->firstOperand) :
            filter_var($this->firstOperand, FILTER_VALIDATE_INT) !== false;
    }
}

