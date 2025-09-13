<?php

namespace Esposimo\Assertion\Strings;

use Esposimo\Assertion\AbstractAssert;

/**
 * Class StringStartsWithAssertion
 *
 * This class extends the AbstractAssert class and provides an assertion mechanism
 * to check if a string starts with a specified prefix.
 *
 * <p>The assertion supports case-sensitive and case-insensitive checks.
 * You can configure this behavior via the setCaseSensitive method.</p>
 *
 * <p>By default, case-sensitivity is disabled.</p>
 */
class StringStartsWithAssertion extends AbstractAssert
{

    /**
     * @var bool $caseSensitive
     * <p>
     * Indicates whether the assertion checks should be performed in a case-sensitive manner.
     * </p>
     * <p>
     * If set to <code>false</code>, the comparison will ignore case differences.
     * Otherwise, it will be strictly case-sensitive.
     * </p>
     */
    protected bool $caseSensitive = false;

    /**
     * Sets the case sensitivity for the assertions.
     *
     * <p>This method allows you to configure whether the assertions should be case sensitive or not.
     * Modifying this setting resets the result of the last check to null.</p>
     *
     * @param bool $caseSensitive A boolean value where `true` enables case sensitivity and `false` disables it.
     *
     * @return static Returns the current instance to allow method chaining.
     */
    public function setCaseSensitive(bool $caseSensitive): static
    {
        $this->caseSensitive = $caseSensitive;
        $this->check = null;
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        $stack = $this->firstOperand;;
        $need = $this->secondOperand;
        if ($this->caseSensitive === false) {
            $stack = strtolower($this->firstOperand);
            $need = strtolower($this->secondOperand);
        }
        $this->check = str_starts_with($stack, $need);
    }
}