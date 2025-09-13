<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Compare;

use Esposimo\Assertion\AbstractAssert;

/**
 * Represents an assertion that verifies whether two operands are not equal.
 *
 * <p>This class extends the {@see AbstractAssert} class and allows you to configure the assertion
 * using various options, such as strict comparison and case sensitivity. After configuration,
 * the assertion logic is applied to check if the two operands are not equal.</p>
 *
 * <p>The {@see AbstractAssert} base class provides methods to set the operands and retrieve the result of
 * the comparison. The main logic for the "not equal" check is implemented in the {@see assert()} method.</p>
 *
 * <h2>Configuration Options:</h2>
 * <ul>
 *   <li>The <b>strict mode</b> determines whether the comparison uses strict equality (`===`) or weak
 *       equality (`==`).</li>
 *   <li>The <b>case sensitivity</b> option defines whether string comparisons should consider case differences
 *       or ignore them.</li>
 * </ul>
 *
 * <h2>Key Methods:</h2>
 * <ul>
 *   <li>{@see setStrict()} - Configures the mode of comparison (strict or weak).</li>
 *   <li>{@see setCaseSensitive()} - Configures case sensitivity for string comparisons.</li>
 * </ul>
 *
 * <h2>Usage Example:</h2>
 * <ul>
 *   <li>Instantiate the class and set the operands.</li>
 *   <li>Configure comparison options using the appropriate setter methods.</li>
 *   <li>Call the {@see AbstractAssert::isValid()} method to evaluate and retrieve the assertion result.</li>
 * </ul>
 */
class NotEqualAssertion extends AbstractAssert
{
    /**
     * @var bool $strict
     * <p>A boolean variable indicating whether strict mode is enabled.</p>
     * <p>When <code>true</code>, the assertions will likely include stricter comparison rules or behaviors.</p>
     */
    private bool $strict = true;
    /**
     * Indicates whether the assertion should be case-sensitive.
     *
     * <p>When set to <strong>true</strong>, string comparisons will consider case differences.
     * When set to <strong>false</strong>, string comparisons will be case-insensitive.</p>
     *
     * @var bool $caseSensitive
     */
    private bool $caseSensitive = true;

    /**
     * Configures the assertion to perform a strict (type-sensitive) comparison.
     *
     * <p>When strict mode is enabled, comparisons will take into account the data type of the operands.
     * If strict mode is disabled, loose (type-insensitive) comparisons will be performed.</p>
     *
     * <p>Calling this method invalidates the result of the previous assertion and resets it.</p>
     *
     * @param bool $strict A boolean value specifying whether to enable strict comparison:
     *                     <ul>
     *                       <li><code>true</code> - Enables strict comparison (data type and value).</li>
     *                       <li><code>false</code> - Enables loose comparison (value only).</li>
     *                     </ul>
     * @return static Returns the current instance for method chaining.
     */
    public function setStrict(bool $strict): static
    {
        $this->strict = $strict;
        $this->check = null; // Invalida il risultato precedente
        return $this;
    }

    /**
     * Sets the case sensitivity for string comparisons.
     *
     * <p>This method allows the user to define whether the assertion
     * should differentiate based on the case of the strings. If set
     * to <code>true</code>, the comparison will be case-sensitive;
     * otherwise, it will be case-insensitive. When called, it also
     * invalidates the previous comparison result.</p>
     *
     * @param bool $caseSensitive Specifies whether the comparison should be case-sensitive.
     *                            <ul>
     *                              <li><code>true</code>: Enables case-sensitive comparisons.</li>
     *                              <li><code>false</code>: Enables case-insensitive comparisons.</li>
     *                            </ul>
     *
     * @return static Returns the current assertion instance for method chaining.
     */
    public function setCaseSensitive(bool $caseSensitive): static
    {
        $this->caseSensitive = $caseSensitive;
        $this->check = null; // Invalida il risultato precedente
        return $this;
    }

    /**
     * <p>Performs the core assertion logic for the class by comparing two operands.</p>
     * <p>This method evaluates the operands, considering additional conditions such as
     * case sensitivity or strict comparison, and stores the result of the evaluation
     * in the <code>$check</code> property inherited from <code>AbstractAssert</code>.</p>
     *
     * <ul>
     *   <li>When both operands are strings and case sensitivity is disabled, it performs
     *       a case-insensitive comparison.</li>
     *   <li>If strict mode is enabled, it checks for strict inequality (<code>!==</code>);
     *       otherwise, it evaluates loose inequality (<code>!=</code>).</li>
     * </ul>
     *
     * @return void This method does not return a value but updates the internal
     *              <code>$check</code> property with the assertion result.
     */
    protected function assert(): void
    {

        if (!$this->caseSensitive && is_string($this->firstOperand) && is_string($this->secondOperand)) {
            $this->check = (strcasecmp($this->firstOperand, $this->secondOperand) !== 0);
            return;
        }


        if ($this->strict) {
            $this->check = ($this->firstOperand !== $this->secondOperand);
        } else {
            $this->check = ($this->firstOperand != $this->secondOperand);
        }
    }
}

