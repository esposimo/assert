<?php

/**
 * This class represents a configurable array that validates its structure based on predefined rules.
 * ConfigurableArray ensures the structure of the provided array adheres to specific keys and formats.
 */

namespace esposimo\assert;

use InvalidArgumentException;
use ReflectionException;
use ReflectionClass;

/**
 * This class represents a configurable array that validates its structure based on predefined rules and constraints.
 * ConfigurableArray ensures that the given configuration adheres to required and optional keys, validates its type*/
class ConfigurableArray
{


    /**
     * An array defining keys that are required for a particular operation or data structure.
     * - 'type': Specifies the type or category of the operation or data.
     * - 'operands': Represents the elements or values involved in the operation.
     */
    const array MANDATORY_KEYS = [ 'type', 'operands' ];

    /**
     * An array defining the optional keys that can be used in a specific context or configuration.
     */
    const array OPTIONAL_KEYS = [ 'properties', 'children' ];

    /**
     * Defines an array of keys used to represent operands.
     */
    const array OPERAND_KEYS = [ 'left' , 'right'];

    /**
     * Indicates whether unknown keys should be ignored during processing.
     */
    public static bool $ignoreUnknownKeys = true;


    /**
     * Represents a configuration array used to store application settings or parameters.
     */
    private array $config;


    /**
     * Constructor method for initializing the class with configuration.
     *
     * @param array $config An array of configuration values required for initialization.
     * @return void
     */
    public function __construct(array $config)
    {
        $this->validate($config);
        $this->config = $config;
    }

    /**
     * Validates the provided configuration array by performing a series of checks
     * on its keys, type, operands, and optional parameters.
     *
     * @param array $config An associative array containing configuration data to be validated.
     *
     * @throws ReflectionException
     * @return void
     */
    public function validate(array $config) : void
    {
        $this->validateKeys($config);
        $this->validateType($config['type']);
        $this->validateOperands($config['operands']);
        $this->validateOptionalParameters($config);

    }

    /**
     * Validates the provided configuration array by ensuring all required keys are present
     * and no unknown keys exist.
     *
     * @param array $config An associative array containing configuration data to validate.
     *
     * @return void
     */
    private function validateKeys(array $config) : void
    {
        $this->validateRequiredKeys($config);
        $this->validateNoUnknownKeys($config);
    }
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
     * Validates the provided configuration array to ensure it does not contain any unknown keys.
     * Throws an exception if a key is found that is not part of the pre-defined valid keys.
     *
     * @param array $config An associative array containing configuration data to validate.
     *
     * @return void
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
     * Validates the provided type to ensure it meets the required criteria.
     * The type must be either a valid assertion type, a callable, or a class that extends AbstractAssertion.
     *
     * @param mixed $type The value to be validated as a type.
     *
     * @throws InvalidArgumentException If the type is invalid.
     * @return void
     *
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
     * Validates the provided operands array by ensuring all mandatory keys are present.
     *
     * @param array $operands An associative array containing operand data to validate.
     *
     * @return void
     */
    private function validateOperands(array $operands) : void
    {
        foreach(self::OPERAND_KEYS as $key)
        {
            if (!array_key_exists($key, $operands))
            {
                throw new InvalidArgumentException(sprintf("Missing mandatory key '%s' in 'operands' key", $key));
            }
        }
    }

    /**
     * Validates optional parameters in the given configuration array, if they are defined.
     *
     * @param array $config An associative array containing configuration data that may include optional parameters.
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
    }


    /**
     * Validates the 'properties' key in the provided configuration array. Ensures that the properties
     * correspond to valid property names within the appropriate class or assertion type.
     *
     * @param array $config An associative array containing configuration data, specifically including
     *                      the 'properties' key and 'type' key for validation.
     *
     * @throws InvalidArgumentException If the 'properties' key is not an array, or if it contains
     *                                  invalid property names that do not correspond to the expected class.
     * @throws ReflectionException
     * @return void
     *
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
     * Validates the 'children' key in the provided configuration array.
     *
     * @param array $config The configuration array to validate. It should contain a 'children' key
     *                       with an array value if present.
     *
     * @throws InvalidArgumentException If the 'children' key is not an array or if an error occurs
     *                                  while creating a ConfigurableArray instance.
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


}