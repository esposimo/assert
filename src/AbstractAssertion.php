<?php

namespace esposimo\assert;

/**
 * Classe astratta che rappresenta un'asserzione generica tra due operandi.
 *
 * La classe `AbstractAssertion` funge da base per la creazione di asserzioni specifiche
 * che possono essere utilizzate per confrontare due valori (gli "operandi") e definire
 * il comportamento in caso di successo o fallimento del test.
 *
 * Questa classe include metodi per:
 * - Configurare gli operandi.
 * - Gestire i risultati delle asserzioni (successo o fallimento).
 * - Creare dinamicamente istanze configurate di classi specifiche utilizzando Reflection.
 *
 * La logica specifica del confronto deve essere definita nelle sottoclassi implementando il
 * metodo astratto `test()`.
 *
 * @package esposimo\assert
 * @abstract
 */
abstract class AbstractAssertion
{

    /**
     * Identificativo per l'asserzione da utilizzare nella configurazione di ConfigurableArray.
     *
     * @var string
     */
    const string ASSERT_EQUALS = 'equals';
    const string ASSERT_EQUALS_CS = 'equalsCs';

    /**
     * Elenco delle asserzioni disponibili per la configurazione.
     *
     * @var string[]
     */
    const array ASSERT_LIST = [
        self::ASSERT_EQUALS,
        self::ASSERT_EQUALS_CS,
    ];

    /**
     * Mappa di corrispondenza tra identificatori di asserzioni e classi specifiche.
     *
     * Può essere estesa nelle sottoclassi o tramite configurazioni personalizzate,
     * e permette di associare identificativi come `equals` a classi specifiche.
     *
     * @var array<string, string>
     */
    const array ASSERT_MAP = [
        self::ASSERT_EQUALS => Equals::class,
    ];


    /**
     * Operando sinistro dell'asserzione.
     *
     * Questo sarà uno dei valori da confrontare nel test dell'asserzione.
     * Il tipo dell'operando è generico e può accettare qualsiasi dato.
     *
     * @var mixed
     */
    protected mixed $leftOperand;

    /**
     * Operando destro dell'asserzione.
     *
     * Questo rappresenta il secondo valore da confrontare nel test dell'asserzione.
     * Come l'operando sinistro, può accettare qualsiasi tipo di dato.
     *
     * @var mixed
     */
    protected mixed $rightOperand;


    /**
     * Array che contiene i risultati del test in caso di successo.
     *
     * Questo array può essere configurato per indicare elementi, messaggi o dati
     * che rappresentano l'esito positivo dell'asserzione.
     *
     * @var array
     */
    protected array $success = [];


    /**
     * Array che contiene i risultati del test in caso di fallimento.
     *
     * Questo array può essere configurato per rappresentare i dati, gli errori o
     * i messaggi relativi al fallimento dell'asserzione.
     *
     * @var array
     */
    protected array $fails = [];


    /**
     * Costruisce un'asserzione con due operandi.
     *
     * @param mixed $leftOperand L'operando sinistro da confrontare.
     * @param mixed $rightOperand L'operando destro da confrontare.
     */
    public function __construct(mixed $leftOperand, mixed $rightOperand)
    {
        $this->setLeftOperand($leftOperand);
        $this->setRightOperand($rightOperand);
    }

    /**
     * Imposta l'operando sinistro dell'asserzione.
     *
     * @param mixed $leftOperand Il valore dell'operando sinistro.
     * @return void
     */
    public function setLeftOperand(mixed $leftOperand) : void
    {
        $this->leftOperand = $leftOperand;
    }

    /**
     * Imposta l'operando destro dell'asserzione.
     *
     * @param mixed $rightOperand Il valore dell'operando destro.
     * @return void
     */
    public function setRightOperand(mixed $rightOperand) : void
    {
        $this->rightOperand = $rightOperand;
    }

    /**
     * Crea dinamicamente un'istanza di una classe derivata configurata.
     *
     * Questo metodo permette di creare una nuova istanza della classe corrente
     * o di una classe derivata, configurando gli operandi e opzionalmente
     * inizializzando altre proprietà specificate nel parametro `$properties`.
     *
     * @param mixed $leftOperand Operando sinistro.
     * @param mixed $rightOperand Operando destro.
     * @param array $properties Array associativo [nomeProprietà => valore] per configurare le proprietà aggiuntive.
     * @return static L'istanza configurata della classe derivata.
     * @throws \InvalidArgumentException Se una proprietà specificata non esiste nella classe.
     * @throws \ReflectionException Se si verifica un errore durante l'utilizzo di Reflection.
     */
    public static function createInstance(mixed $leftOperand, mixed $rightOperand, array $properties = []) : static
    {
        $reflectionClass = new \ReflectionClass(static::class);
        $instance = $reflectionClass->newInstance($leftOperand, $rightOperand);

        foreach($properties as $property => $value)
        {
            if (!$reflectionClass->hasProperty($property))
            {
                throw new \InvalidArgumentException(sprintf("Property %s not found in %s", $property, static::class));
            }
            $propertyReflection = $reflectionClass->getProperty($property);
            $propertyReflection->setValue($instance, $value);
        }
        return $instance;
    }

    /**
     * Restituisce i risultati dell'asserzione in caso di successo.
     *
     * @return array Array contenente i dati relativi al successo dell'asserzione.
     */
    public function getSuccess() : array
    {
        return $this->success;
    }

    /**
     * Restituisce i risultati dell'asserzione in caso di fallimento.
     *
     * @return array Array contenente i dati relativi al fallimento dell'asserzione.
     */
    public function getFailure() : array
    {
        return $this->fails;
    }


    /**
     * Metodo astratto per eseguire il confronto tra operandi.
     *
     * Ogni classe derivata deve implementare questo metodo per fornire la logica
     * specifica del test. Generalmente deve restituire `true` o `false` in base
     * all'esito dell'asserzione.
     *
     * @return bool `true` se l'asserzione è soddisfatta, altrimenti `false`.
     */
    abstract public function test() : bool;

}