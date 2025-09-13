# Esposito/Assertion

[![Latest Version on Packagist](https://img.shields.io/packagist/v/esposimo/assertion.svg?style=flat-square)](https://packagist.org/packages/esposimo/assertion)
[![Total Downloads](https://img.shields.io/packagist/dt/esposimo/assertion.svg?style=flat-square)](https://packagist.org/packages/esposimo/assertion)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

An extensible assertion library for PHP using the Composite pattern.

This library provides a simple and extensible way to perform assertions in your PHP projects. It is designed with a focus on extensibility, allowing you to create your own custom assertion logic with minimal effort.

## Installation

You can install the package via Composer:

```bash
composer require esposimo/assertion
```

## Usage

The library is designed to be intuitive and flexible. Here are some examples of how to use it.

### Basic Assertions

Each assertion is a class that can be instantiated and then validated.

```php
use Esposimo\Assertion\Compare\EqualAssertion;
use Esposimo\Assertion\Types\IsStringAssertion;

$assertion = new EqualAssertion(5, 5);
var_dump($assertion->isValid()); // bool(true)

$assertion = new IsStringAssertion("hello");
var_dump($assertion->isValid()); // bool(true)
```

### Combining Assertions with Conjunctions

You can combine multiple assertions using `AndConjunction` and `OrConjunction`.


```php
use Esposimo\Assertion\AndConjunction;
use Esposimo\Assertion\Compare\GreaterThanAssertion;
use Esposimo\Assertion\Types\IsIntAssertion;

$value = 10;

$assertion = new AndConjunction([
new IsIntAssertion($value),
new GreaterThanAssertion($value, 5)
]);

var_dump($assertion->isValid()); // bool(true)
```

### Negating Assertions

You can negate any assertion using the `NotAssertion` class.

```php
use Esposimo\Assertion\NotAssertion;
use Esposimo\Assertion\Types\IsNullAssertion;

$assertion = new NotAssertion(new IsNullAssertion(null));
var_dump($assertion->isValid()); // bool(false)
```

### Creating a Custom Assertion

Creating a new assertion is as simple as extending the ´AbstractAssert´ class and implementing the `assert() method.

```php
use Esposimo\Assertion\AbstractAssert;

class IsPositiveNumberAssertion extends AbstractAssert
{
    protected function assert(): void
    {
        $this->check = is_numeric($this->firstOperand) && $this->firstOperand > 0;
    }
}

$assertion = new IsPositiveNumberAssertion(10);
var_dump($assertion->isValid()); // bool(true)

$assertion = new IsPositiveNumberAssertion(-5);
var_dump($assertion->isValid()); // bool(false)
```

## Available Assertions

Here is a list of the assertions available out of the box:

- [Array](blob/main/src/Array)
  - [ArrayContainsAssertion](blob/main/src/Array/ArrayContainsAssertion.php)
  - [ArrayHasKeyAssertion](blob/main/src/Array/ArrayHasKeyAssertion.php)
  - [CountAssertion](blob/main/src/Array/CountAssertion.php) 
- [Compare](blob/main/src/Compare) 
  - [EqualAssertion](blob/main/src/Compare/EqualAssertion.php)
  - [GreaterThanAssertion](blob/main/src/Compare/GreaterThanAssertion.php)
  - [InRangeAssertion](blob/main/src/Compare/InRangeAssertion.php)
  - [LessThanAssertion](blob/main/src/Compare/LessthanAssertion.php)
  - [NotEqualAssertion](blob/main/src/Compare/NotEqualAssertion.php)
- [Strings](blob/main/src/Strings) 
  - [RegexAssertion](blob/main/src/Strings/RegexAssertion.php) 
  - [StringContainsAssertion](blob/main/src/Strings/StringContainsAssertion.php)
  - [StringEndsWithAssertion](blob/main/src/Strings/StringEndsWithAssertion.php)
  - [StringStartsWithAssertion](blob/main/src/Strings/StringStartsWithAssertion.php)
- [Types](blob/main/src/Types)
  - [IsArrayAssertion](blob/main/src/Types/IsArrayAssertion.php)
  - [IsEmptyAssertion](blob/main/src/Types/IsEmptyAssertion.php)
  - [IsFloatAssertion](blob/main/src/Types/IsFloatAssertion.php)
  - [IsInstanceAssertion](blob/main/src/Types/IsInstanceAssertion.php)
  - [IsIntAssertion](blob/main/src/Types/IsIntAssertion.php)
  - [IsNotEmptyAssertion](blob/main/src/Types/IsNotEmptyAssertion.php)
  - [IsNotNullAssertion](blob/main/src/Types/IsNotNullAssertion.php)
  - [IsNullAssertion](blob/main/src/Types/IsNullAssertion.php)
  - [IsNumericAssertion](blob/main/src/Types/IsNumericAssertion.php)
  - [IsStringAssertion](blob/main/src/Types/IsStringAssertion.php)

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue.

## License

The MIT License (MIT). Please see [LICENSE](./LICENSE) for more information.