<?php

namespace Esposimo\Assertion\Array;

use Esposimo\Assertion\AbstractAssert;
use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\Compare\GreaterThanAssertion;
use Esposimo\Assertion\Compare\InRangeAssertion;
use Esposimo\Assertion\Compare\LessThanAssertion;

/**
 * Class CountAssertion
 *
 * <p>This class extends the AbstractAssert class to allow assertions based on the count of the first operand.
 * It provides multiple methods to define the type of comparison (equal, greater than, less than, in range).</p>
 *
 */
class CountAssertion extends AbstractAssert
{

    /**
     * <p>
     * This property holds an instance of the comparator used for performing equality checks
     * or other comparison-based assertions.
     * It is typically utilized to define the logic for determining how the operands are compared.
     * </p>
     */
    protected ?AbstractAssert $instanceCompare;

    /**
     * Constructor to initialize the assertion class with operands.
     * <p>
     * Sets up the two operands for comparison and initializes an instance
     * of the EqualAssertion class for further checks.
     * </p>
     *
     * @param mixed $firstOperand The first operand, which may be null or any data type.
     * @param mixed $secondOperand The second operand, which may be null or any data type.
     *
     * @return void
     */
    public function __construct(mixed $firstOperand = null, mixed $secondOperand = null)
    {
        parent::__construct($firstOperand, $secondOperand);
        $this->instanceCompare = new EqualAssertion(count($firstOperand), $secondOperand);
    }

    /**
     * Configures the assertion to use the equality comparison.
     *
     * <p>This method sets the comparison mechanism to `EqualAssertion` using the
     * two operands currently configured in the class.</p>
     * <p>The result of the assertion is reset and must be recalculated by invoking
     * the `isValid()` method.</p>
     *
     * @return static Returns the current instance of the class for method chaining.
     */
    public function useEqualCompare() : static
    {
        $this->instanceCompare = new EqualAssertion($this->getCountFirstOperand(), $this->getSecondOperand());
        $this->check = null;
        return $this;
    }

    /**
     * Configures the assertion to use the greater-than comparison logic.
     *
     * <p>This allows the current assertion to validate whether the first operand is
     * greater than the second operand. Optionally, the comparison can be configured
     * to include equality using the inclusive flag.</p>
     *
     * @param bool $setInclusive If set to true, the comparison will include equality (greater than or equal to).
     *                           Defaults to false for strict greater-than comparison.
     *
     * @return static Returns the current assertion instance for method chaining.
     */
    public function useGreaterThanCompare(bool $setInclusive = false) : static
    {
        $this->instanceCompare = new GreaterThanAssertion($this->getCountFirstOperand(), $this->getSecondOperand());
        $this->instanceCompare->setInclusive($setInclusive);
        $this->check = null;
        return $this;
    }

    /**
     * Configures the assertion to use a "less than" comparison between the two operands.
     * The comparison behavior can be optionally set to inclusive.
     *
     * <p>This method sets up the instance to compare the operands using the <code>LessThanAssertion</code>.
     * The inclusivity of the comparison can be configured by setting <code>$setInclusive</code> to <code>true</code>.
     * After configuration, the result of the check is reset to <code>null</code>.
     *
     * @param bool $setInclusive Determines whether the "less than" comparison is inclusive or exclusive.
     *                            - <code>true</code>: Performs a "less than or equal to" comparison.
     *                            - <code>false</code>: Performs a strict "less than" comparison.
     *
     * @return static Returns the current instance to allow method chaining.
     */
    public function useLessThanCompare(bool $setInclusive = false) : static
    {
        $this->instanceCompare = new LessThanAssertion($this->getCountFirstOperand(), $this->getSecondOperand());
        $this->instanceCompare->setInclusive($setInclusive);
        $this->check = null;
        return $this;
    }

    /**
     * Retrieves the count of elements in the first operand.
     *
     * <p>This method counts the number of elements present in the first operand,
     * which can be configured after instantiating the assertion class.</p>
     *
     * @return int The total number of elements in the first operand.
     */
    private function getCountFirstOperand() : int
    {
        return count($this->getFirstOperand());
    }

    /**
     * Configures an assertion to check if the first operand is within a specified range.
     *
     * <p>This method allows you to define a range (minimum and maximum) and optionally
     * specify if the range boundaries are inclusive.</p>
     *
     * @param int $min The minimum value of the range.
     * @param int $max The maximum value of the range.
     * @param bool $minInclusive (Optional) Indicates whether the minimum value is inclusive. Defaults to false.
     * @param bool $maxInclusive (Optional) Indicates whether the maximum value is inclusive. Defaults to false.
     * @return static Returns the current instance after configuring the range-based comparison.
     */
    public function useInRangeCompare(int $min, int $max, bool $minInclusive = false, bool $maxInclusive = false) : static
    {
        $this->instanceCompare = new InRangeAssertion($this->getCountFirstOperand(), $min, $max);
        $this->instanceCompare->setInclusive($minInclusive, $maxInclusive);
        $this->check = null;
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        $this->check = $this->instanceCompare->isValid();
    }
}