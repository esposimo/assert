<?php

declare(strict_types=1);

namespace Esposimo\Assertion\Compare;

use Esposimo\Assertion\AbstractAssert;
use Esposimo\Assertion\AndConjunction;

/**
 * The InRangeAssertion class is an implementation of an assertion that checks if a value falls within a specific range.
 *
 * <p>
 * This class extends the AbstractAssert base class, which provides methods to manage operands and retrieve the result
 * of the last check.
 * </p>
 *
 * <p>
 * The assertion considers both the minimum and maximum boundaries, which can be inclusive or exclusive based on the
 * configuration chosen.
 * </p>
 *
 * <h3>Features:</h3>
 * <ul>
 *   <li>Configure minimum and maximum boundaries using the methods <code>setMin()</code>, <code>setMax()</code>, or
 *       <code>setMinMax()</code>.
 *   </li>
 *   <li>Toggle between inclusive or exclusive boundaries with the <code>setInclusive()</code> method.</li>
 * </ul>
 *
 * <h3>Comparison Behavior:</h3>
 * <ul>
 *   <li>If either operand is a string, the assertion automatically fails and return <code>false</code>.</li>
 * </ul>
 */
class InRangeAssertion extends AbstractAssert
{
    /**
     * A boolean flag that determines if the minimum boundary in a given range will be inclusive.
     *
     * <p>This variable is usually used in scenarios where range checking or comparisons are needed,
     * and it allows for flexibility in handling inclusive or exclusive range boundaries.</p>
     *
     * <ul>
     *   <li>When set to <code>true</code>, the minimum boundary is considered inclusive (i.e., the boundary itself is a part of the range).</li>
     *   <li>When set to <code>false</code>, the minimum boundary is exclusive (i.e., the boundary itself is not included in the range).</li>
     * </ul>
     *
     * <p>Default value is <code>false</code>.</p>
     */
    private bool $inclusiveMin = false;

    /**
     * Indicates whether the maximum value in a range should be inclusive.
     *
     * <p>If set to <b>false</b>, the maximum value is excluded from the range
     * checks. If set to <b>true</b>, the maximum value is included.</p>
     *
     * <ul>
     *   <li><b>false</b> - The maximum limit is not included in validation.</li>
     *   <li><b>true</b> - The maximum limit is included in validation.</li>
     * </ul>
     *
     * <p>This variable is typically used in conjunction with validation or
     * assertion logic to determine how range boundaries are evaluated.</p>
     */
    private bool $inclusiveMax = false;

    /**
     * Represents the minimum value in a range or comparison.
     *
     * <p>If set to <b>null</b>, there is no lower boundary restriction for the value being checked.
     * When provided a value, it indicates that the value being evaluated should be greater than
     * or equal to this minimum value, depending on the assertion logic implemented.</p>
     *
     * <ul>
     *   <li><b>null</b> - No restriction on the minimum limit for validation.</li>
     *   <li><b>specific value</b> - Defines the lowest permissible value for assertions.</li>
     * </ul>
     *
     * <p>This property is commonly used in assertions or validation contexts to configure
     * the lower boundary of a range of acceptable values.</p>
     */
    private mixed $min = null;

    /**
     * Specifies the maximum value allowed in a given range or condition.
     *
     * <p>If set to <b>null</b>, no maximum limit is enforced during the checks. This allows
     * for unrestricted validation or assertion on the upper boundary.</p>
     *
     * <ul>
     *   <li><b>null</b> - No maximum limit is applied; the upper boundary is unrestricted.</li>
     *   <li><b>non-null value</b> - Applies the specified maximum value as the upper limit.</li>
     * </ul>
     *
     * <p>This variable is commonly used to define an upper boundary for validation or assertion
     * logic and can dynamically determine whether an upper limit should apply.</p>
     */
    private mixed $max = null;

    /**
     * Constructor for setting up the assertion class with given parameters.
     *
     * <p>This method initializes the assertion by configuring
     * the min and max boundaries and defining the second operand as the value to be checked.</p>
     *
     * @param mixed $value The value to be asserted.
     * @param mixed $min The minimum boundary to be used in assertions.
     * @param mixed $max The maximum boundary to be used in assertions.
     *
     * @return void This method does not return a value.
     */
    public function __construct(mixed $value, mixed $min, mixed $max)
    {
        parent::__construct($value);
        $this->setMin($min);
        $this->setMax($max);
        $this->setSecondOperand($value);
    }

    /**
     * Configures whether the bounds for the assertion should be inclusive or exclusive.
     *
     * <p>This method allows the developer to specify if the comparison for both the minimum
     * and maximum bounds should include the specified values (inclusive) or exclude them
     * (exclusive).</p>
     *
     * <ul>
     * <li><code>$inclusiveMin</code>: Defines if the minimum bound is inclusive.</li>
     * <li><code>$inclusiveMax</code>: Defines if the maximum bound is inclusive.</li>
     * </ul>
     *
     * <p>After setting these properties, any cached or previous assertion result is invalidated
     * by resetting the <code>$check</code> property to <code>null</code>.</p>
     *
     * @param bool $inclusiveMin Indicates if the minimum bound is considered inclusive.
     * @param bool $inclusiveMax Indicates if the maximum bound is considered inclusive.
     *
     * @return static Returns an instance of the class to allow method chaining.
     */
    public function setInclusive(bool $inclusiveMin, bool $inclusiveMax): static
    {
        $this->inclusiveMin = $inclusiveMin;
        $this->inclusiveMax = $inclusiveMax;
        $this->check = null; // Invalida il risultato precedente
        return $this;
    }

    /**
     * Sets the minimum and maximum values for the assertion.
     *
     * <p>
     * This method allows chaining by invoking {@code setMin()} and {@code setMax()} methods
     * to define the lower and upper bounds for the assertion.
     * </p>
     *
     * @param mixed $min The minimum value to compare against.
     * @param mixed $max The maximum value to compare against.
     *
     * @return static Returns the current instance of the assertion class for method chaining.
     */
    public function setMinMax(mixed $min, mixed $max) : static
    {
        return $this->setMin($min)->setMax($max);
    }

    /**
     * Sets the maximum value for the assertion and resets the current check result.
     *
     * <p>This method allows configuring the maximum operand used in an assertion.
     * Once the maximum is set, the current result of the assertion check is cleared,
     * making it necessary to re-evaluate the assertion after all changes are made.</p>
     *
     * @param mixed $max The maximum value to be set. Can be of any type depending on the assertion logic.
     *
     * @return static Returns the current instance for method chaining.
     */
    public function setMax(mixed $max) : static
    {
        $this->max = $max;
        $this->check = null;
        return $this;
    }

    /**
     * Sets the minimum value for the assertion and resets the validation check result.
     *
     * <p>This method is used to configure the lower boundary for an assertion. By setting
     * this value, the object can validate whether the configured operands adhere to the
     * specified minimum constraint. The validation result is reset after setting the new
     * minimum, allowing for updated checks when the assertion logic is executed again.</p>
     *
     * @param mixed $min The minimum value to be set as the lower boundary for the assertion.
     *                   This can be of any type supported by the assertion logic.
     *
     * @return static The current assertion instance to allow for method chaining.
     */
    public function setMin(mixed $min) : static
    {
        $this->min = $min;
        $this->check = null;
        return $this;
    }

    /**
     * <p>Performs an assertion check on the two configured operands. This method evaluates whether both operands pass a set of conditions
     * defined within a logical conjunction of assertions.</p>
     *
     * @return void No value is returned. The result of the assertion is stored in the <code>$check</code> property of the object.
     */
    protected function assert(): void
    {
        if ((is_string($this->firstOperand)) || (is_string($this->secondOperand)))
        {
            $this->check = false;
            return;
        }

        $between_left = new GreaterThanAssertion($this->firstOperand);
        $between_left->setFirstOperand($this->firstOperand)
            ->setSecondOperand($this->min)
            ->setInclusive($this->inclusiveMin);

        $between_right = new LessThanAssertion($this->secondOperand);
        $between_right->setFirstOperand($this->secondOperand)
            ->setSecondOperand($this->max)
            ->setInclusive($this->inclusiveMax);


        $conjunction = new AndConjunction();
        $conjunction->add($between_left);
        $conjunction->add($between_right);

        $this->check = $conjunction->isValid();

    }
}

