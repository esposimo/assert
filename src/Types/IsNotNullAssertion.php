<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * IsNotNullAssertion is responsible for verifying that a single value is not null.
 * Use a not strict check (!== null) to achieve its purpose
 */
class IsNotNullAssertion extends AbstractAssert
{
    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        $this->check = ($this->firstOperand !== null);
    }
}

