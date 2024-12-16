<?php

namespace esposimo\assert;

class Equals extends AbstractAssertion
{

    /**
     * Configura se il test deve essere eseguito in maniera case-sensitive.
     *
     * @var bool true se il confronto distingue tra maiuscole e minuscole, false altrimenti.
     */
    protected bool $cs = false;


    public function test(): bool
    {
        if (gettype($this->leftOperand) != gettype($this->rightOperand))
        {
            return false;
        }

        if (is_string($this->leftOperand))
        {
            if ($this->cs)
            {
                return (strcmp($this->leftOperand, $this->rightOperand) === 0);
            }
            return (strcasecmp($this->leftOperand, $this->rightOperand) === 0);
        }

        if (is_numeric($this->leftOperand))
        {
            return ($this->leftOperand == $this->rightOperand);
        }

        return false;
    }
}