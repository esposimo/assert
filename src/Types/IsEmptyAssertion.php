<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * IsEmptyAssertion is responsible for verifying that a single value is empty or not.
 * Use empty() function to achieve its purpose
 *
 */
class IsEmptyAssertion extends AbstractAssert
{
    /**
     * Implements the business logic defined for this assertion
     *
     * Use empty() function to achieve its purpose
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = empty($this->firstOperand);
    }
}

