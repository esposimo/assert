<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * IsNotEmptyAssertion is responsible for verifying that a single value is empty or not.
 * Use empty() function, then negate, to achieve its purpose
 *
 */
class IsNotEmptyAssertion extends AbstractAssert
{
    /**
     * Implements the business logic defined for this assertion
     *
     * Use empty() function, then negate, to achieve its purpose
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = !empty($this->firstOperand);
    }
}

