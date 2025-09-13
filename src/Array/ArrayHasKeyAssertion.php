<?php

namespace Esposimo\Assertion\Array;

use Esposimo\Assertion\AbstractAssert;
use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\Compare\GreaterThanAssertion;
use Esposimo\Assertion\Compare\InRangeAssertion;
use Esposimo\Assertion\Compare\LessThanAssertion;

/**
 * Class ArrayHasKeyAssertion
 *
 * <p>This class extends the {@see AbstractAssert} class and provides an assertion to verify if a given key exists
 * in an array. It utilizes the <code>array_key_exists()</code> function to perform this check, ensuring that
 * the presence of the specified key in the defined array (first operand) is correctly validated.</p>
 *
 * <p>The implementation of the <code>assert()</code> method ensures that the result of the key existence check
 * is stored in the <code>$check</code> property of the parent {@see AbstractAssert} class. This result can be
 * retrieved using the appropriate methods inherited from <code>AbstractAssert</code>.</p>
 *
 */
class ArrayHasKeyAssertion extends AbstractAssert
{
    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        $this->check = array_key_exists($this->secondOperand, $this->firstOperand);
    }
}