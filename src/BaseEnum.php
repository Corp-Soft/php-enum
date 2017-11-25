<?php

namespace CorpSoft\Enum;

use BadMethodCallException;
use ReflectionClass;
use UnexpectedValueException;

/**
 * Class BaseEnum
 *
 * @package CorpSoft\Enum
 */
abstract class BaseEnum
{
    /**
     * The cached list of constants by name.
     *
     * @var array
     */
    protected static $byName = [];

    /**
     * The cached list of constants by value.
     *
     * @var array
     */
    protected static $byValue = [];

    /**
     * @var array list of properties
     */
    protected static $list = [];

    /**
     * The value managed by this type instance.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Sets the value that will be managed by this type instance.
     *
     * @param mixed $value The value to be managed
     *
     * @throws UnexpectedValueException If the value is not valid
     */
    public function __construct($value)
    {
        if (!static::isValidValue($value)) {
            throw new UnexpectedValueException("Value '{$value}' is not part of the enum " . get_called_class());
        }

        $this->value = $value;
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     *
     * @param string $name
     * @param array $arguments
     *
     * @throws BadMethodCallException
     *
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        $constants = static::getConstantsByName();

        if (isset($constants[$name])) {
            return new static($constants[$name]);
        }

        throw new BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * Creates a new type instance using the name of a value.
     *
     * @param string $name The name of a value
     *
     * @throws UnexpectedValueException
     *
     * @return $this The new type instance
     */
    public static function createByName($name)
    {
        $constants = static::getConstantsByName();
        if (!array_key_exists($name, $constants)) {
            throw new UnexpectedValueException("Name '{$name}' is not exists in the enum constants list " . get_called_class());
        }

        return new static($constants[$name]);
    }

    /**
     * get constant key by value(label)
     *
     * @param $value
     *
     * @return mixed
     */
    public static function getValueByName($value)
    {
        return array_search($value, static::listData());
    }

    /**
     * Creates a new type instance using the value.
     *
     * @param mixed $value The value
     *
     * @throws UnexpectedValueException
     *
     * @return $this The new type instance
     */
    public static function createByValue($value)
    {
        if (!array_key_exists($value, static::getConstantsByValue())) {
            throw new UnexpectedValueException("Value '{$value}' is not exists in the enum constants list " . get_called_class());
        }

        return new static($value);
    }

    /**
     * Get list data
     *
     * @return mixed
     */
    public static function listData()
    {
        return static::$list;
    }

    /**
     * Get label by value
     *
     * @var string value
     *
     * @param mixed $value
     *
     * @return string label
     */
    public static function getLabel($value): ?string
    {
        return static::$list[$value] ?? null;
    }

    /**
     * Returns the list of constants (by name) for this type.
     *
     * @return array The list of constants by name
     */
    public static function getConstantsByName()
    {
        $class = get_called_class();

        if (!array_key_exists($class, static::$byName)) {
            $reflection = new ReflectionClass($class);
            static::$byName[$class] = $reflection->getConstants();
        }

        return static::$byName[$class];
    }

    /**
     * Returns the list of constants (by value) for this type.
     *
     * @return array The list of constants by value
     */
    public static function getConstantsByValue()
    {
        $class = get_called_class();

        if (!isset(static::$byValue[$class])) {
            static::$byValue[$class] = array_flip(static::getConstantsByName());
        }

        return static::$byValue[$class];
    }

    /**
     * Returns the name of the value.
     *
     * @return array|string The name, or names, of the value
     */
    public function getName()
    {
        $constants = static::getConstantsByValue();

        return $constants[$this->value];
    }

    /**
     * Unwraps the type and returns the raw value.
     *
     * @return mixed The raw value managed by the type instance
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Checks if a name is valid for this type.
     *
     * @param string $name The name of the value
     *
     * @return bool If the name is valid for this type, `true` is returned.
     * Otherwise, the name is not valid and `false` is returned
     */
    public static function isValidName($name): bool
    {
        return array_key_exists($name, static::getConstantsByName());
    }

    /**
     * Checks if a value is valid for this type.
     *
     * @param string $value The value
     *
     * @return bool If the value is valid for this type, `true` is returned.
     * Otherwise, the value is not valid and `false` is returned
     */
    public static function isValidValue($value): bool
    {
        return array_key_exists($value, static::getConstantsByValue());
    }
}
