<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * Verifies that the provided value is a float number.
 *
 * This class checks whether the given value is either a float type
 * or represents a numeric value (e.g., a string containing a float number).
 *
 * The assertion can be configured to strictly validate numeric types only,
 * or to allow values that represent a number in string for
 *
 * This class is an extension of {@see IsNumericAssertion}
 */
class IsFloatAssertion extends IsNumericAssertion
{
    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        if ($this->strictCheck)
        {
            $this->check = is_float($this->firstOperand);
            return;
        }
        $floatVal = (float) $this->firstOperand;
        $intVal = (int) $floatVal;
        $this->check = $floatVal != $intVal;
    }
}

