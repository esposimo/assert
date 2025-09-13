<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * IsArrayAssertion is responsible for verifying that a single value is present within an array.
 * The value being searched for can be of any variable type
 */
class IsArrayAssertion extends AbstractAssert
{
    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = is_array($this->firstOperand);
    }
}

