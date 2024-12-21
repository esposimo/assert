<?php

namespace esposimo\assert;

use InvalidArgumentException;
use ReflectionException;
use ReflectionClass;
use RuntimeException;

/**
 * This class represents a configurable array that validates its structure based on predefined rules and constraints.
 * ConfigurableArray ensures that the given configuration adheres to required and optional keys, validates its type*/
class ConfigurableArray
{


    /**
     * Lista delle chiavi obbligatorie presenti nella configurazione
     */
    const array MANDATORY_KEYS = [ 'type', 'check_value' ];

    /**
     * Lista delle chiavi opzionali presenti nella configurazione
     */
    const array OPTIONAL_KEYS = [ 'properties', 'children' , 'success', 'fail' ];

    /**
     * Indica se ignorare o meno chiavi sconosciute
     */
    public static bool $ignoreUnknownKeys = true;

    /**
     * Rappresenta la configurazione dell'array
     */
    private array $config;

    /**
     * Contiene i valori da considerare nel caso di condizione <code>true</code>
     * @var array
     */
    protected array $success = array();

    /**
     * Contiene i valori da contenere nel caso di condizione <code>false</code>
     * @var array
     */
    protected array $fail = array();

    /**
     * Contiene il merge dei valori restituiti dall'asserzione e dei suoi figli (solo quelli relativi al risultato dell'asserzione)
     * @var array
     */
    protected array $data = array();

    /**
     * Contiene il risultato dell'asserzione
     * @var bool
     */
    protected bool $result = false;

    /**
     * Metodo costruttore per inizializzare la classe con le sue configurazioni
     *
     * @param array $config Array di configurazioni
     * @throws ReflectionException
     * @return void
     */
    public function __construct(array $config)
    {
        $this->validate($config);
        $this->config = $config;
    }

    /**
     * Valida le configurazioni fornite quando viene istanziata la classe
     *
     * @param array $config Array di configurazioni che contiene almeno i valori <code>type</code> e <code>check_value</code>
     *
     * @throws InvalidArgumentException|ReflectionException Quando una delle validazioni dell'array di configurazioni fallisce o quando vengono valutate le condizioni
     *
     */
    public function validate(array $config) : void
    {
        $this->validateKeys($config);
        $this->validateType($config['type']);
        $this->validateOptionalParameters($config);

    }

    /**
     * Valida le chiavi fornite nell'array config
     *
     * @param array $config Array di configurazioni da validare. Si assicura che tutte le chiavi necessarie esistano
     *
     * @throws InvalidArgumentException Se una chiave obbligatoria non esiste, oppure esiste una chiave sconosciuta e <code>ConfigurableArray::$ignoreUnknownKeys</code> è <code>true</code>
     * @return void
     *
     */
    private function validateKeys(array $config) : void
    {
        $this->validateRequiredKeys($config);
        $this->validateNoUnknownKeys($config);
    }

    /**
     * Valida che tutte le chiavi obbligatorie siano presenti nell'array di configurazione fornito.
     *
     * @param array $config L'array di configurazione da validare. Deve contenere tutte le chiavi richieste definite in MANDATORY_KEYS.
     *
     * @throws InvalidArgumentException Se una o più chiavi obbligatorie sono assenti dall'array di configurazione.
     * @return void
     *
     */
    private function validateRequiredKeys(array $config) : void
    {
        foreach(self::MANDATORY_KEYS as $key)
        {
            if (!array_key_exists($key, $config))
            {
                throw new InvalidArgumentException(sprintf("Missing mandatory key '%s'", $key));
            }
        }
    }

    /**
     * Valida che l'array di configurazione non contenga chiavi sconosciute.
     *
     * @param array $config L'array di configurazione da validare. Le chiavi nell'array devono corrispondere
     *                      alle chiavi obbligatorie od opzionali previste se la validazione delle chiavi sconosciute è abilitata.
     *
     * @throws InvalidArgumentException Se l'array di configurazione contiene chiavi che non sono
     *                                  definite nell'elenco delle chiavi obbligatorie od opzionali.
     * @return void
     *
     */

    private function validateNoUnknownKeys(array $config) : void
    {
        if (!self::$ignoreUnknownKeys)
        {
            return;
        }
        $validKeys = array_merge(self::MANDATORY_KEYS, self::OPTIONAL_KEYS);
        foreach($config as $key => $value)
        {
            if (!in_array($key, $validKeys))
            {
                throw new InvalidArgumentException(sprintf("Unknown key '%s'", $key));
            }
        }
    }

    /**
     * Valida il tipo fornito rispetto ai tipi consentiti o ai vincoli di callable/classi.
     *
     * @param mixed $type Il tipo da validare. Deve essere un valore presente in
     *                    AbstractAssertion::ASSERT_LIST, una callable o una classe che
     *                    estende AbstractAssertion.
     *
     * @throws InvalidArgumentException Se il tipo fornito non soddisfa uno dei vincoli
     *                                  specificati.
     * @return void
     */
    private function validateType($type) : void
    {
        if (
            !in_array($type, AbstractAssertion::ASSERT_LIST) &&
            !is_callable($type) &&
            !(class_exists($type) && in_array(AbstractAssertion::class, class_parents($type)))
        )
        {
            throw new InvalidArgumentException("Invalid value in 'type' key");
        }
    }

    /**
     * Valida i parametri opzionali nell'array di configurazione fornito, se definiti.
     *
     * @param array $config Un array associativo contenente dati di configurazione che possono includere parametri opzionali.
     *
     * @throws ReflectionException
     * @return void
     */
    private function validateOptionalParameters(array $config): void
    {
        if (isset($config['properties'])) {
            $this->validateProperties($config['properties']);
        }
        if (isset($config['children'])) {
            $this->validateChildren($config['children']);
        }
        if (isset($config['success'])) {
            $this->validateSuccessValue($config['success']);
        }
        if (isset($config['fail'])) {
            $this->validateFailValue($config['fail']);
        }
    }


    /**
     * Valida la chiave 'properties' nell'array di configurazione fornito.
     *
     * @param array $config L'array di configurazione da validare. Deve contenere una chiave 'properties'
     *                      con un valore di tipo array e una chiave 'type' valida che faccia riferimento a una classe di asserzione appropriata.
     *
     * @throws InvalidArgumentException|ReflectionException Se la chiave 'properties' non è un array, se viene specificata una proprietà inesistente,
     *                                  o se la chiave 'type' fa riferimento a una classe non valida.
     * @return void
     */
    private function validateProperties(array $config) : void
    {
        if (!array_key_exists('properties', $config))
        {
            return;
        }
        if (!is_array($config['properties']))
        {
            throw new InvalidArgumentException(sprintf("Invalid value in 'properties' key. Array required"));
        }
        $type = $config['type'];
        if (
            !in_array($type, AbstractAssertion::ASSERT_LIST) &&
            !(class_exists($type) && in_array(AbstractAssertion::class, class_parents($type)))
        )
        {
            return;
        }

        $class_ns = AbstractAssertion::ASSERT_MAP[$type];
        $reflection = new ReflectionClass($class_ns);
        $properties = array_keys($config['properties']);
        $properties_class_names = [];
        foreach($reflection->getProperties() as $classProperty)
        {
            $properties_class_names[] = $classProperty->getName();
        }
        foreach($properties as $property)
        {
            if (!in_array($property, $properties_class_names))
            {
                throw new InvalidArgumentException(sprintf("Invalid property '%s' in 'properties' key", $property));
            }
        }
    }

    /**
     * Valida la chiave 'children' nell'array di configurazione fornito.
     * Garantisce che, se la chiave 'children' esiste, il suo valore sia un array e che
     * l'array possa essere correttamente inizializzato come un oggetto ConfigurableArray.
     *
     * @param array $config L'array di configurazione da validare.
     *
     * @throws InvalidArgumentException|ReflectionException Se la chiave 'children' non è un array o se l'array non può essere configurato come un ConfigurableArray.
     * @return void
     *
     */
    private function validateChildren(array $config) : void
    {
        if (!array_key_exists('children', $config))
        {
            return;
        }

        if (!is_array($config['children']))
        {
            throw new InvalidArgumentException(sprintf("Invalid value in 'children' key. Array required"));
        }

        try {
            new ConfigurableArray($config['children']);
        }
        catch (InvalidArgumentException $e)
        {
            throw new InvalidArgumentException(sprintf("Invalid value in 'children' data config. %s", $e->getMessage()));
        }
    }

    /**
     * Valida e imposta il valore di 'success'.
     * Assegna l'array fornito alla proprietà success della classe.
     *
     * @param array $success L'array che rappresenta il valore di success da validare e memorizzare.
     *
     * @return void
     */
    public function validateSuccessValue(array $success) : void
    {
        $this->success = $success;
    }

    /**
     * Assegna il valore fornito alla proprietà 'fail' della classe.
     *
     * @param array $fail L'array
     */
    public function validateFailValue(array $fail) : void
    {
        $this->fail = $fail;
    }

    /**
     * Restituisce il valore della proprietà privata 'result'.
     *
     * @return bool Il valore booleano della proprietà 'result'.
     */
    public function getResult() : bool
    {
        return $this->result;
    }

    /**
     * Restituisce i dati memorizzati nella proprietà interna dell'oggetto.
     *
     * @return array I dati attualmente memorizzati.
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * Esegue la validazione o l'azione configurata in base all'oggetto di configurazione fornito.
     * Supporta tipi callable, asserzioni predefinite dall'ASSERT_LIST e asserzioni personalizzate
     * che estendono AbstractAssertion. Gestisce scenari di successo e fallimento, così come configurazioni
     * di 'children' quando presenti.
     *
     * @throws InvalidArgumentException Se la configurazione o i suoi componenti sono invalidi.
     * @throws RuntimeException|ReflectionException Se si verifica un errore durante l'esecuzione di callable o asserzioni personalizzate.
     * @return void
     *
     */
    public function run() : void
    {

        $config = (object) $this->config;

        $type = $config->type;
        $check_value = $config->check_value;
        $properties = ($config->properties) ? $config->properties : [];
        $success = ($config->success) ? $config->success : [];
        $fail = ($config->fail) ? $config->fail : [];

        if (is_callable($type))
        {
            // capire cosa mettere se è una callable
            // passare check_value e properties alla callable ?
        }

        if (in_array($type, AbstractAssertion::ASSERT_LIST))
        {
            // ho indicato il nome della classe presente tra quelle disponibili
            $classname = AbstractAssertion::ASSERT_MAP[$type];
            $instance = forward_static_call(array($classname, 'createInstance'), $check_value, $properties, $success, $fail);
            if ($instance->test())
            {
                $merge = $instance->getSuccess();
                if (isset($config->children))
                {
                    $childrenConfig = new ConfigurableArray((array) $config->children);
                    $childrenConfig->run();
                    $merge = array_merge($merge, $childrenConfig->getData());
                }
            }
            else
            {
                $merge = $instance->getFail();
            }
            $this->data = $merge;
        }

        if (class_exists($type) && in_array(AbstractAssertion::class, class_parents($type)))
        {
            // ho indicato una classe che estende la AbstractAssertion ma non è definita in AbstractAssertion
        }
    }
}