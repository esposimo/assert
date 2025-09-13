<?php

namespace Esposimo\Assertion;

/**
 * Execute a NOT on Assertion Instance
 *
 * <p>The NotAssertion class is an extension of the AbstractAssert class, designed to perform
 * logical negation on the result of a given operand's assertion.</p>
 *
 */

class NotAssertion extends AbstractAssert
{
    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        $this->check = !$this->firstOperand->isValid();
    }
}