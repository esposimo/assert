<?php

declare(strict_types=1);

namespace Esposimo\Assertion;

/**
 * An interface representing the contract for any assertion.
 *
 * This interface is the foundation of the assertion library, defining
 * a method that every concrete assertion class must implement. The primary
 * responsibility of an implementation is to evaluate the assertion logic and
 * provide a boolean result indicating whether the assertion condition is met.
 *
 * <p><strong>Usage:</strong> Classes implementing this interface should perform
 * their specific assertion checks in a manner that is idempotent and free of
 * side effects. Repeated calls to the method should yield the same result as
 * long as the underlying state remains unchanged.
 *
 * <p><strong>Implementation Details:</strong>
 * <ul>
 *   <li>The {@see isValid} method should encapsulate the core assertion logic.</li>
 *   <li>The method is expected to return a boolean value: `true` if the
 *       assertion condition is satisfied, and `false otherwise.</li>
 * </ul>
 */
interface AssertableInterface
{
    /**
     * Determines whether the assertion is valid by returning the result of the last check performed.
     *
     * <p>
     * This method evaluates if the conditions configured in the assertion have been met.
     * To provide accurate results, ensure the operands have been properly set and the `assert()` method has been called.
     * </p>
     *
     * @return bool Returns <code>true</code> if the last check resulted in success (assertion is valid),
     *              or <code>false</code> if it failed (assertion is invalid).
     */
    public function isValid(): bool;
}