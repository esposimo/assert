<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Types;

use Esposimo\Assertion\AbstractAssert;

/**
 * Verifies that a given value is of type string.
 *
 * This assertion can be configured to return `true` even if the string is empty.
 */
class IsStringAssertion extends AbstractAssert
{
    /**
     * Determines whether the assertion should return `true` when the string is empty.
     *
     * When set to `true`, empty strings are considered valid.
     * When set to `false`, only non-empty strings will pass the assertion.
     *
     * @var bool
     */
    private bool $emptyStringCheck = false;

    /**
     * Initializes the class.
     *
     * @param string $value The value to be assigned or validated.
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    /**
     * Sets whether the assertion should return `true` when the string is empty.
     *
     * @param bool $emptyStringCheck True to consider empty strings as valid, false otherwise.
     * @return static The current instance to allow method chaining.
     */
    public function setEmptyStringCheck(bool $emptyStringCheck): static
    {
        $this->emptyStringCheck = $emptyStringCheck;
        $this->check = null;
        return $this;
    }

    /**
     * Implements the business logic defined for this assertion
     *
     * @return void
     */
    protected function assert(): void
    {
        if ($this->emptyStringCheck)
        {
            $this->check = is_string($this->firstOperand);
            return;
        }
        $this->check = (is_string($this->firstOperand) && $this->firstOperand != "");
        return;
    }
}

