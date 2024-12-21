<?php

namespace esposimo\assert;

/**
 * Classe astratta che rappresenta la base per implementare asserzioni personalizzate.
 *
 * Fornisce meccanismi di configurazione generici per valori di controllo,
 * proprietà personalizzabili, risultati di successo e fallimento.
 * Questa classe contiene metodi e costanti utili che possono essere estesi e sovrascritti
 * in sottoclassi per implementare logiche di asserzione specifiche.
 */
abstract class AbstractAssertion
{

    /**
     * Identificativo per l'asserzione da utilizzare nella configurazione di ConfigurableArray.
     *
     * @var string
     */
    const string ASSERT_EQUALS = 'equals';

    /**
     * Elenco delle asserzioni disponibili per la configurazione.
     *
     * @var string[]
     */
    const array ASSERT_LIST = [
        self::ASSERT_EQUALS,
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
     * Variabile utilizzata per memorizzare il valore da controllare durante l'esecuzione.
     *
     * @var mixed
     */
    protected mixed $check_value;

    /**
     * Array utilizzato per conservare un insieme di proprietà configurabili.
     * Tali properties vengono definite e documentate dalle classi che estendono <code>AbstractAssertion::class</code>
     *
     * @var array
     */
    protected array $properties = [];

    /**
     * Array utilizzato per memorizzare i valori da mantenere nel caso di successo della condizione
     *
     * @var array
     */
    protected array $success = [];

    /**
     * Array utilizzato per memorizzare i valori da mantenere nel caso di successo della condizione
     *
     * @var array
     */
    protected array $fail = [];

    /**
     * Costruttore per inizializzare l'oggetto con i valori indicati
     *
     * @param mixed $check_value Il valore che l'asserzione deve verificare.
     * @param array $properties Un array di proprietà specifiche della classe che estende <code>AbstractAssertion::class</code>.
     * @param array $success Array di valori da restituire nel caso in cui l'asserzione sia <code>true</code>
     * @param array $fail Array di valori da restituire nel caso in cui l'asserzione sia <code>false</code>
     * @return void
     */
    public function __construct(mixed $check_value, array $properties = [], array $success = [], array $fail = [])
    {
        $this->setCheckValue($check_value);
        $this->setProperties($properties);
        $this->setSuccess($success);
        $this->setFail($fail);
    }

    /**
     * Configura il check value
     *
     * @param mixed $check_value Il valore da testare con l'asserzione
     * @return void
     */
    public function setCheckValue(mixed $check_value): void
    {
        $this->check_value = $check_value;
    }

    /**
     * Restituisce il check value
     *
     * @return mixed The check value.
     */
    public function getCheckValue(): mixed
    {
        return $this->check_value;
    }

    /**
     * Configura le properties dell'asserzione
     *
     * @param array $properties Array associativo di proprietà da configurare
     * @return void
     */
    public function setProperties(array $properties) : void
    {
        $this->properties = $properties;
    }

    /**
     * Restituisce la lista delle proprietà
     *
     * @return array Array delle proprietà.
     */
    public function getProperties() : array
    {
        return $this->properties;
    }

    /**
     * Imposta una proprietà con un nome specificato e un valore fornito.
     *
     * @param string $name Nome della proprietà da impostare.
     * @param mixed $value Valore da assegnare alla proprietà.
     * @return void
     */
    public function setProperty(string $name, mixed $value) : void
    {
        $this->properties[$name] = $value;
    }

    /**
     * Restituisce il valore della proprietà specificata dal nome.
     *
     * @param string $name Nome della proprietà da recuperare.
     * @return mixed Valore della proprietà o null se non esiste.
     */
    public function getProperty(string $name) : mixed
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Imposta l'elenco dei valori da restituire in caso l'asserzione sia <code>true</code>.
     *
     * @param array $success Array contenente i valori da impostare
     * @return void
     */
    public function setSuccess(array $success) : void
    {
        $this->success = $success;
    }

    /**
     * Imposta l'elenco dei valori da restituire in caso l'asserzione sia <code>false</code>
     *
     * @param array $fail Array contenente i valori da impostare
     * @return void
     */
    public function setFail(array $fail) : void
    {
        $this->fail = $fail;
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
    public function getFail() : array
    {
        return $this->fail;
    }

    /**
     *
     * Metodo che viene ereditato dalle classi che estendono <code>AbstractAssertion::class</code>
     *
     * @param mixed $check_value Il valore che l'asserzione deve verificare.
     * @param array $properties Un array di proprietà specifiche della classe che estende <code>AbstractAssertion::class</code>.
     * @param array $success Array di valori da restituire nel caso in cui l'asserzione sia <code>true</code>
     * @param array $fail Array di valori da restituire nel caso in cui l'asserzione sia <code>false</code>
     * @throws \InvalidArgumentException Se una proprietà indicata nell'array <code>$properties</code> non è una proprietà della classe che estende <code>AbstractAssertion::class</code>
     * @throws \RuntimeException Errore generico nella creazione della classe che estende <code>AbstractAssertion::class</code>
     * @return static Restituisce l'istanza della classe che estende <code>AbstractAssertion::class</code>
     */
    public static function createInstance(mixed $check_value, array $properties = [], array $success = [], array $fail = []) : static
    {
        try {

            $reflectionClass = new \ReflectionClass(static::class);
            $instance = $reflectionClass->newInstance($check_value);

            $noOverride = ['check_value', 'success', 'fail'];

            foreach($properties as $property => $value)
            {
                if (!$reflectionClass->hasProperty($property))
                {
                    throw new \InvalidArgumentException(sprintf("Property %s not found in %s", $property, static::class));
                }
                $propertyName = $reflectionClass->getProperty($property)->getName();
                if (!in_array($propertyName, $noOverride))
                {
                    $propertyReflection = $reflectionClass->getProperty($property);
                    $propertyReflection->setValue($instance, $value);
                }
            }

            $successReflection = $reflectionClass->getProperty('success');
            $successReflection->setValue($instance, $success);

            $failReflection = $reflectionClass->getProperty('fail');
            $failReflection->setValue($instance, $fail);

            return $instance;
        }
        catch (\ReflectionException $e)
        {
            throw new \RuntimeException(sprintf("Error creating instance of %s", static::class), 0, $e);
        }
    }

    /**
     * Metodo astratto per eseguire il confronto tra operandi.
     *
     * Ogni classe derivata deve implementare questo metodo per fornire la logica
     * specifica del test. Generalmente deve restituire `true` o `false` in base
     * all'esito dell'asserzione.
     *
     * Il parametro $value è necessario laddove la condizione lo richiede.
     * Se necessario verificare che sia o meno null, si potrebbe incorrere nel problema di capire se il null arriva come valore, o perchè non indicato
     * Per capire in quale delle due condizioni ci si trova, usare func_get_args())
     * se func_get_args() == 0, allora $value è null perchè non è stato passato
     * se func_get_args() == 1, allora $value è stato passato e valeva proprio null
     *
     * @return bool `true` se l'asserzione è soddisfatta, altrimenti `false`.
     */
    abstract public function test(mixed $value = null) : bool;

}