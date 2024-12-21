<?php

namespace esposimo\assert;

/**
 * Questa classe estende AbstractAssertion per confrontare due valori e verificare la loro uguaglianza.
 * Consente confronti case-sensitive o case-insensitive, aggiungendo flessibilità al test tramite configurazioni.
 */
class Equals extends AbstractAssertion
{

    /**
     * Configura se il test deve essere eseguito in maniera case-sensitive.
     *
     * @var bool true se il confronto distingue tra maiuscole e minuscole, false altrimenti.
     */
    protected bool $cs = false;

    /**
     * Memorizza un valore che può essere inizializzato successivamente.
     * Utile per test che non sono stati configurati con <code>ConfigurableArray</code>
     * @var mixed può contenere qualsiasi tipo di dato o essere null.
     */
    protected mixed $value = null;

    /**
     * Effettua il test estendendo il metodo astratto <code>AbstractAssertion::test()</code>
     *
     * @param mixed $value Valore da confrontare. Se null, questa classe prende in considerazione la property $value configurata in $properties con la <code>ConfigurableArray::class</code>
     * @return bool Restituisce true/false in base all'asserzione di uguaglianza tra i due valori
     */
    public function test(mixed $value = null): bool
    {
        if (is_null($value))
        {
            $value = $this->value;
        }

        if (gettype($value) != gettype($this->check_value))
        {
            return false;
        }

        if (is_string($value))
        {
            if ($this->cs)
            {
                return (strcmp($value, $this->check_value) === 0);
            }
            return (strcasecmp($value, $this->check_value) === 0);
        }

        if (is_numeric($value))
        {
            return ($value == $this->check_value);
        }
        return false;
    }
}