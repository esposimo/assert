<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * IsNullAssertion is responsible for verifying that a single value is null.
 * Use strict check (=== null) to achieve its purpose
 *
 */
class IsNullAssertion extends AbstractAssert
{
    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = ($this->firstOperand === null);
    }
}

