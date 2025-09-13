<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * Verifies that a given object is an instance of a specified class.
 *
 * This assertion uses the `is_a()` function to perform the check.
 */
class IsInstanceAssertion extends AbstractAssert
{
    /**
     * Implements the business logic defined for this assertion.
     * This assertion uses the `is_a()` function to perform the check.
     * @return void
     */
    protected function assert(): void
    {
        $this->check = is_a($this->firstOperand, $this->secondOperand);
    }
}

