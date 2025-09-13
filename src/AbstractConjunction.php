<?php

declare(strict_types=1);

namespace Esposimo\Assertion;

/**
 * The AbstractConjunction class serves as a base class for logical conjunctions (e.g., AND, OR) between multiple assertions.
 * <p>
 * This class enables combining assertions (or other conjunctions) for more complex logical checks.
 * It maintains a collection of assertions and provides the functionality to add more dynamically.
 * <p>
 * Classes that extend AbstractConjunction must implement their specific logic for evaluating the combined assertions
 * (e.g., using AND or OR logic) in compliance with the `AssertableInterface`.
 *
 * <h3>Key Features:</h3>
 * <ul>
 *   <li>Supports initialization with an optional set of assertions.</li>
 *   <li>Allows dynamic addition of assertions or other conjunctions using the {@link add()} method.</li>
 *   <li>Provides a flexible structure for building composite assertion logic.</li>
 * </ul>
 */
abstract class AbstractConjunction implements AssertableInterface
{
    /**
     * <p>A container to hold assertion objects. This array can be used to store individual
     * or multiple assertion instances created via classes that extend <code>AbstractAssert</code>.</p>
     *
     * <p>The purpose of this array is to organize and manage different types of assertions
     * that may be performed during validation or testing scenarios.</p>
     *
     * <p>Example usage could include storing equality assertions, type checks,
     * array validations, or complex logical conjunctions using <code>AndConjunction</code>
     * or <code>OrConjunction</code>.</p>
     */
    protected array $assertions = [];

    /**
     * Initializes the assertion class with an array of predefined assertions.
     *
     * <p>This constructor accepts an array of assertions and iterates over them,
     * adding each assertion to the class instance. This allows for batch configuration
     * of assertions during object instantiation.</p>
     *
     * @param array $assertions An array of assertion objects to be added to the instance.
     * Each object must be compatible with the assertion library and implement a valid assertion mechanism.
     *
     * @return void This method does not return any value.
     */
    public function __construct(array $assertions = [])
    {
        foreach ($assertions as $assertion) {
            $this->add($assertion);
        }
    }

    /**
     * Adds a new assertion to the current instance.
     *
     * <p>This method allows adding an assertion object that implements the AssertableInterface
     * to the internal collection of assertions. Once added, the assertion can be utilized
     * as part of the overall assertion logic configured within the instance.</p>
     *
     * @param AssertableInterface $assertion An assertion object implementing the AssertableInterface.
     * This object defines a specific assertion logic to be applied.
     *
     * @return static Returns the current instance to allow method chaining.
     */
    public function add(AssertableInterface $assertion): static
    {
        $this->assertions[] = $assertion;
        return $this;
    }
}
