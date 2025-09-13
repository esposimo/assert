<?php

namespace Esposimo\Assertion\Strings;

use Esposimo\Assertion\AbstractAssert;

/**
 * Class StringContainsAssertion
 *
 * <p>A class to perform string containment assertions.</p>
 *
 * <p>The assertion can be configured to perform case-sensitive or case-insensitive checks which can be
 * set using the {@see StringContainsAssertion::setCaseSensitive()} method.</p>
 *
 */
class StringContainsAssertion extends AbstractAssert
{

    /**
     * @var bool $caseSensitive
     *
     * <p>This variable determines whether the assertions should be performed in a case-sensitive manner.</p>
     * <p>By default, it is set to <code>false</code>, which means case insensitivity is applied.</p>
     */
    protected bool $caseSensitive = false;

    /**
     * Configures the assertion to be case-sensitive or case-insensitive.
     *
     * <p>This method allows you to set whether the assertions performed should
     * consider case sensitivity. When set to `true`, assertions will take case into account.
     * When set to `false`, case will be ignored. The result of the last check
     * will also be reset after modifying this setting.
     *
     * @param bool $caseSensitive A boolean indicating whether the assertion should be case-sensitive (`true`) or case-insensitive (`false`).
     *
     * @return static Returns the current instance of the assertion class for method chaining.
     */
    public function setCaseSensitive(bool $caseSensitive): static
    {
        $this->caseSensitive = $caseSensitive;
        $this->check = null;
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function assert(): void
    {
        if ($this->caseSensitive) {
            $this->check = str_contains($this->firstOperand, $this->secondOperand);
        } else {
            $this->check = (stripos($this->firstOperand, $this->secondOperand) !== false);
        }
    }
}