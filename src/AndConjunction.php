<?php

declare(strict_types=1);

namespace Esposimo\Assertion;

/**
 * Represents a logical AND conjunction of multiple assertions.
 *
 * <p>This class extends <code>AbstractConjunction</code> and evaluates all attached assertions as part
 * of an AND operation. If all assertions are valid, the conjunction is valid; if any one of the assertions
 * is invalid, the conjunction is invalid.</p>
 *
 * <p>An AND conjunction is considered vacuously valid if no assertions are added (i.e., an empty set).</p>
 *
 * <h2>Usage</h2>
 * <p>To use this class, add one or more assertions to the conjunction. Call <code>isValid()</code> to evaluate
 * all assertions with the AND logic.</p>
 *
 * <h3>Behavior</h3>
 * <ul>
 *  <li>If no assertions are added to the conjunction, <code>isValid()</code> will return <code>true</code>.</li>
 *  <li>If at least one assertion evaluates to <code>false</code>, the conjunction will immediately stop
 *      evaluation and return <code>false</code>.</li>
 *  <li>If all assertions evaluate to <code>true</code>, the conjunction will return <code>true</code>.</li>
 * </ul>
 */
class AndConjunction extends AbstractConjunction
{
    /**
     * Determines the validity of a set of assertions.
     *
     * <p>This method evaluates whether all configured assertions are valid. If no assertions
     * exist, it assumes the set is vacuously true. The first invalid assertion results in a
     * failure for the entire group.</p>
     *
     * <p>The assertions can be configured and modified dynamically after the class is instantiated,
     * allowing for flexible validation scenarios. The method iterates through the assertions
     * sequentially and stops as soon as an invalid assertion is encountered.</p>
     *
     * @return bool Returns <code>true</code> if all assertions in the group are valid or if no
     * assertions are present; otherwise, returns <code>false</code>.
     */
    public function isValid(): bool
    {
        if (empty($this->assertions)) {
            return true;
        }

        foreach ($this->assertions as $assertion) {
            if (!$assertion->isValid()) {
                return false;
            }
        }
        return true;
    }
}
