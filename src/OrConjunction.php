<?php

declare(strict_types=1);

namespace Esposimo\Assertion;

/**
 * Represents a logical OR conjunction for combining multiple assertions within the assertion library.
 *
 * <p>The OrConjunction class checks whether at least one of the added assertions evaluates to true.
 * If all assertions evaluate to false or if no assertions are present, the conjunction will
 * evaluate to false.</p>
 *
 * <h4>Behavior</h4>
 * <lu>
 *   <li>If the assertions collection is empty, the conjunction evaluates to <code>false</code>.</li>
 *   <li>The iteration process stops as soon as it finds an assertion that is valid, at which point
 *       the conjunction evaluates to <code>true</code>.</li>
 *   <li>If no assertion in the collection is valid, the conjunction evaluates to <code>false</code>.</li>
 * </lu>
 *
 * <h4>Usage</h4>
 * <p>The class extends {@see AbstractConjunction}, and uses the base functionality to manage the
 * assertions collection. The primary method to override is the <code>isValid()</code> method,
 * which implements the specific OR conjunction logic, ensuring it evaluates the added assertions correctly.</p>
 */
class OrConjunction extends AbstractConjunction
{
    /**
     * {@inheritdoc}
     */
    public function isValid(): bool
    {
        if (empty($this->assertions)) {
            return false;
        }
        
        foreach ($this->assertions as $assertion) {
            if ($assertion->isValid()) {
                return true;
            }
        }
        return false;
    }
}
