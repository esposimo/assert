<?php

namespace Esposimo\Assertion\Strings;

use Esposimo\Assertion\AbstractAssert;

/**
 * Provides a specialized assertion class that facilitates regular expression pattern matching.
 *
 * <p>Main features:</p>
 * <ul>
 *   <li>Configurable pattern and subject via {@see setPattern()} and {@see setSubject()}.</li>
 *   <li>Outputs all captured matches through {@see getCapturedMatches()}.</li>
 *   <li>Retrieves a specific captured group by index using {@see getCaptureMatch()}.</li>
 * </ul>
 */
class RegexAssertion extends AbstractAssert
{
    /**
     * An array used to store the matches captured during a specific operation or process.
     *
     * @var array $capturedMatches
     */
    protected array $capturedMatches = [];

    /**
     * Sets the subject to be used in the assertion.
     *
     * <p>This method sets the subject on which the regular expression will be applied.
     * Configuring a subject deletes any previously captured matches.
     * </p>
     *
     * @param string $subject The subject value to be set
     * @return static Returns the current instance for fluent method chaining.
     */
    public function setSubject(string $subject): static
    {
        $this->capturedMatches = [];
        return $this->setSecondOperand($subject);
    }

    /**
     * Sets the pattern to be used in the assertion.
     *
     * <p>This method sets the pattern to be used in the regular expression
     * Configuring a pattern deletes any previously captured matches.
     * </p>
     *
     * @param string $pattern The pattern value to be set
     * @return static Returns the current instance for fluent method chaining.
     */
    public function setPattern(string $pattern): static
    {
        $this->capturedMatches = [];
        return $this->setFirstOperand($pattern);
    }

    /**
     * Retrieves the captured matches from the last assertion check.
     *
     * <p>This method returns the matches captured during the evaluation of the last
     * assertion executed using the assertion mechanism. The data format and structure of the
     * returned value is the same as that of preg_match_all().</p>
     *
     * @return array An array containing the captured matches. See {@see \preg_match_all()}
     */
    public function getCapturedMatches(): array
    {
        return $this->capturedMatches;
    }

    /**
     * Retrieves a specific captured match from the result of a previous assertion.
     *
     * <p>This method accesses the array of captured matches from the assertion process
     * and returns the match at the specified index. If the index does not exist, it
     * returns null.</p>
     *
     * @param int $index The index of the captured match to retrieve.
     * @return string|null The captured match at the specified index, or null if the index
     * does not exist in the captured matches array.
     */
    public function getCaptureMatch(int $index) : ?string
    {
        return $this->capturedMatches[$index] ?? null;
    }


    /**
     * Execute the assertion
     */
    protected function assert(): void
    {
        $this->capturedMatches = [];
        $this->check = preg_match_all($this->firstOperand, $this->secondOperand, $this->capturedMatches);
    }
}