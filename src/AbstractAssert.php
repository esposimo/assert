<?php

declare(strict_types=1);

namespace Esposimo\Assertion;

/**
 * AbstractAssert is a core component of a simple assertion library.
 * <p>
 * This abstract class allows developers to build custom assertion logic by extending it.
 * It serves as the foundation for implementing assertions, providing mechanisms for
 * configuring operands, executing the assertion, and retrieving the result of the assertion.
 * </p>
 *
 * <p>To create a custom assertion:</p>
 * <ol>
 *    <li>Extend the <code>AbstractAssert</code> class.</li>
 *    <li>Implement the <code>assert()</code> method with the specific logic to evaluate the assertion.</li>
 *    <li>Ensure the <code>$check</code> property is updated within the <code>assert()</code> method to reflect the outcome.</li>
 * </ol>
 */
abstract class AbstractAssert implements AssertableInterface
{
    /**
     * @var bool|null $check
     * <p>This property stores the result of the last assertion performed by any class
     * extending <code>AbstractAssert</code>. The value of <code>$check</code>
     * will typically be set within the <code>assert()</code> method implemented
     * in the extending class.</p>
     *
     * <ul>
     *    <li><b>True:</b> Indicates that the assertion passed.</li>
     *    <li><b>False:</b> Indicates that the assertion failed.</li>
     *    <li><b>Null:</b> Default state indicating no assertion has been performed yet.</li>
     * </ul>
     *
     * <p>Developers should ensure the <code>assert()</code> method properly updates this property
     * as it directly reflects the success or failure of the specified assertion logic.</p>
     */
    protected ?bool $check = null;

    /**
     * Initializes an instance of the assertion class with optional operands.
     * <p>
     * This constructor allows setting up the first and second operands to be used
     * in assertions. These operands can later be reconfigured using the methods provided
     * by the <code>AbstractAssert</code> class. By default, both operands are set to
     * <code>null</code>.
     * </p>
     * <p>
     * The operands provided here will serve as the initial values for any comparison or
     * assertion logic implemented in the extended assertion class.
     * </p>
     *
     * @param mixed $firstOperand The first operand to be used in the assertion logic.
     *                             Can be any data type.
     * @param mixed $secondOperand The second operand to be used in the assertion logic.
     *                             Can also be any data type.
     *
     * @return void The constructor does not return a value, as it is used only to initialize
     *              the object's operand properties.
     */
    public function __construct(
        protected mixed $firstOperand = null,
        protected mixed $secondOperand = null
    ) {}


    /**
     * Executes the core logic for the assertion.
     * <p>
     * This abstract method is intended to be implemented by any custom assertion class
     * extending the AbstractAssert class. The implementation should contain the specific
     * logic for evaluating the assertion based on the operands configured.
     * </p>
     * <p>
     * The result of the evaluation must be stored in the property <code>AbstractAssert::$check</code>,
     * which will determine if the assertion has passed or failed.
     * </p>
     *
     * @return void This method does not return a value, as it directly sets the assertion result
     *              in the <code>AbstractAssert::$check</code> property.
     */
    abstract protected function assert(): void;

    /**
     * Sets the first operand for the assertion.
     * <p>
     * This method is used to configure the first operand, which will be used in the assertion's evaluation.
     * Setting the operand automatically resets the result of the last assertion.
     * </p>
     *
     * @param mixed $firstOperand The value to be used as the first operand in the assertion.
     *                            It can be of any data type, depending on the context of the assertion.
     *
     * @return static Returns the current instance of the assertion object, allowing for method chaining.
     */
    public function setFirstOperand(mixed $firstOperand): static
    {
        $this->firstOperand = $firstOperand;
        $this->check = null;
        return $this;
    }

    /**
     * Retrieves the first operand configured for the assertion.
     * <p>
     * This method returns the value of the first operand that has been set for the assertion
     * in the current instance of the class. The operand represents the first input
     * to be used in the logical evaluation of the assertion.
     * </p>
     * <p>
     * The value of the first operand can be of any data type, as it depends entirely
     * on the context and requirements of the specific assertion being implemented.
     * </p>
     *
     * @return mixed The value of the first operand configured in the assertion.
     */
    public function getFirstOperand(): mixed
    {
        return $this->firstOperand;
    }

    /**
     * Sets the second operand for the assertion.
     *
     * <p>
     * This method is used to configure the second operand, which will be used in the assertion's evaluation.
     * Setting the operand automatically resets the result of the last assertion.
     * </p>
     *
     * @param mixed $secondOperand The value to be used as the second operand in the assertion.
     *                            It can be of any data type, depending on the context of the assertion.
     *
     * @return static Returns the current instance of the assertion object, allowing for method chaining.
     */
    public function setSecondOperand(mixed $secondOperand): static
    {
        $this->secondOperand = $secondOperand;
        $this->check = null;
        return $this;
    }

    /**
     * Retrieves the second operand configured for the assertion.
     *
     * <p>
     * This method returns the value of the second operand that has been set for the assertion
     * in the current instance of the class. The operand represents the second input
     * to be used in the logical evaluation of the assertion.
     * </p>
     * <p>
     * The value of the second operand can be of any data type, as it depends entirely
     * on the context and requirements of the specific assertion being implemented.
     * </p>
     * <p>In many cases the extended assertion class doesn't need the second operand</p>
     *
     * @return mixed The value of the second operand configured in the assertion.
     */

    public function getSecondOperand(): mixed
    {
        return $this->secondOperand;
    }

    /**
     * Executes the assertion if needed
     *
     *
     * <p>Performs the assertion calling `assert()` method under one or both of the following cases:
     * <ul>
     *     <li>The second operand has changed</li>
     *     <li>The assertion has never been performed</li>
     * </ul>
     * In all other cases, it returns the value of the last assertion.
     * </p>
     *
     * @param mixed $secondOperand An optional operand to be compared or asserted against
     *                             the primary operand. If provided and different from the
     *                             current second operand, the new value will be set.
     * @return void This method does not return a value; it updates the state of the instance
     *              by either modifying <code>$secondOperand</code> or executing the
     *              assertion logic to determine the result.
     */
    public function check(mixed $secondOperand = null): void
    {
        if ($secondOperand !== null && $this->secondOperand !== $secondOperand) {
            $this->setSecondOperand($secondOperand);
        }

        if ($this->check === null) {
            $this->assert();
        }
    }

    /**
     * Return the result of assertion
     *
     * @param mixed $secondOperand An optional parameter to reconfigure the second operand for the assertion.
     *                             If omitted, the existing second operand is used for the evaluation.
     * @return bool Returns <code>true</code> if the assertion is valid and passes based on the configured operands;
     *              returns <code>false</code> otherwise.
     */
    public function isValid(mixed $secondOperand = null): bool
    {
        $this->check($secondOperand);
        return $this->check;
    }
}
