<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Compare;

use Esposimo\Assertion\AbstractAssert;

/**
 * The EqualAssertion class provide a mechanism for performing equality between two operands
 *
 * <p>The default behavior of the class uses strict comparison (===) for equality checks. You can toggle
 * between strict and loose comparison modes using the {@see EqualAssertion::setStrict()} method.
 * Additionally, case sensitivity during string comparisons can be controlled via the {@see EqualAssertion::setCaseSensitive()} method.</p>
 *
 * <ul>
 *   <li><b>Strict Mode:</b> When strict mode is enabled, the class will use strict comparison (===).</li>
 *   <li><b>Case Sensitivity:</b> When enabled, string comparisons are case-sensitive. Can be toggled off for case-insensitive checks.</li>
 * </ul>
 */
class EqualAssertion extends AbstractAssert
{
    /**
     * Determines whether strict comparison is applied in assertions.
     *
     * <ul>
     *  <li>If <code>true</code>, the assertion will perform strict comparisons.</li>
     *  <li>If <code>false</code>, the assertion will perform non-strict comparisons.</li>
     * </ul>
     *
     * <p>Default value is <code>true</code>.</p>
     *
     * @var bool $strict
     */
    private bool $strict = true;

    /**
     * Defines whether the comparison should be case-sensitive
     *
     * <ul>
     *  <li>If <code>true</code>, string comparisons will be case-sensitive</li>
     *  <li>If <code>false</code>, string comparison will be case-insensitive</li>
     * </ul>
     *
     * <p>Default value is <code>true</code>.</p>
     *
     * @var bool $caseSensitive
     */
    private bool $caseSensitive = true;

    /**
     * Configures whether the comparison should be strict or lenient.
     *
     * <p>When strict mode is enabled, comparisons will use strict type checking (e.g., `===`),
     * otherwise, loose type checking (e.g., `==`) will be used.</p>
     *
     * <p>The property <code>AbstractAssertion::$check</code> is reset to <code>null</code>
     * after calling this method, invalidating any previously performed assertion.</p>
     *
     * @param bool $strict <code>true</code> to enable strict comparisons, <code>false</code> for lenient (non-strict) comparisons.
     * @return static The current instance to allow method chaining.
     */
    public function setStrict(bool $strict): static
    {
        $this->strict = $strict;
        $this->check = null; // Invalida il risultato precedente
        return $this;
    }

    /**
     * Configures whether the string comparison should be case-sensitive.
     *
     * <p>This method allows you to set whether the assertions involving string operands
     * should distinguish between uppercase and lowercase characters.</p>
     * <p>By default, comparisons are case-sensitive, but this method enables toggling
     * this behavior. Invoking this method also invalidates any previously stored comparison
     * result by setting the check property to null.</p>
     *
     * @param bool $caseSensitive Indicates if the comparison should be case-sensitive.
     *                             Pass <code>true</code> for case-sensitive comparison
     *                             and <code>false</code> for case-insensitive comparison.
     *
     * @return static Returns the current instance of the class to allow method chaining.
     */
    public function setCaseSensitive(bool $caseSensitive): static
    {
        $this->caseSensitive = $caseSensitive;
        $this->check = null; // Invalida il risultato precedente
        return $this;
    }

    /**
     * Performs the core assertion logic specific to the class by comparing the operands.
     *
     * <p>This method evaluates the two operands configured in the AbstractAssert class
     * to determine if the assertion passes or fails. The result of this evaluation
     * is stored in the `$check` property of the parent class.</p>
     *
     * @return void This method does not return a value. It updates the `$check` property
     * to indicate whether the assertion passed (`true`) or failed (`false`).
     */
    protected function assert(): void
    {
        if (!$this->caseSensitive && is_string($this->firstOperand) && is_string($this->secondOperand)) {
            $this->check = (strcasecmp($this->firstOperand, $this->secondOperand) === 0);
            return;
        }

        if ($this->strict) {
            $this->check = ($this->firstOperand === $this->secondOperand);
        } else {
            $this->check = ($this->firstOperand == $this->secondOperand);
        }
    }
}

