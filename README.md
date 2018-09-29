# php-curry

[![Code Coverage](https://scrutinizer-ci.com/g/matteosister/php-curry/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matteosister/php-curry/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/matteosister/php-curry/badges/build.png?b=master)](https://scrutinizer-ci.com/g/matteosister/php-curry/build-status/master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/437a51d1-9829-4e22-b37b-77c80dd3947f/mini.png)](https://insight.sensiolabs.com/projects/437a51d1-9829-4e22-b37b-77c80dd3947f)

An implementation for currying in PHP

Currying a function means the ability to pass a subset of arguments to a function, and receive back another function that accepts the rest of the arguments. As soon as the last one is passed it gets back the final result.

Like this:

``` php
use Cypress\Curry as C;

$adder = function ($a, $b, $c, $d) {
  return $a + $b + $c + $d;
};

$firstTwo = C\curry($adder, 1, 2);
echo $firstTwo(3, 4); // output 10

$firstThree = $firstTwo(3);
echo $firstThree(14); // output 20
```

Currying is a powerful (yet simple) concept, very popular in other, more purely functional languages. In haskell for example, currying is the default behavior for every function.

In PHP we still need to rely on a wrapper to simulate the behavior

## How to install

``` bash
composer require cypresslab/php-curry
```

In your PHP scripts (with composer autoloader in place) just import the namespace and use it!

``` php
use Cypress\Curry as C;

$chunker = C\curry('array_chunk', ['a', 'b']);
var_dump($chunker(1)); // output [['a'], ['b']]
var_dump($chunker(2)); // output [['a', 'b']]
```

### Right to left

It's possible to curry a function from left (default) or from right.

``` php
$divider = function ($a, $b) {
    return $a / $b;
};

$divide10By = C\curry($divider, 10);
$divideBy10 = C\curry_right($divider, 10);

echo $divide10By(10); // output 1
echo $divideBy10(100); // output 10
```

**Caveat** Only the required arguments go from right, optional argument are apppended (from left).

``` php
$divider = function ($a, $b, $decimals = 0, $dec_point = '.') {
    return number_format($a / $b, $decimals, $dec_point);
};

$divide10By = C\curry($divider, 10);
$divideBy10 = C\curry_right($divider, 10);

echo $divide10By(10, 2, ','); // output 1,00
echo $divideBy10(100, 2, ','); // output 10,00
```

### Parameters as an array

You can also curry a function and pass the parameters as an array, just use the \*_args version of the function.

``` php
use Cypress\Curry as C;

$divider = function ($a, $b) {
    return $a / $b;
};

$division = C\curry_args($divider, [100, 10]);
echo $division(); // output 10

$division2 = C\curry_right_args($divider, [100, 10]);
echo $division2(); // output 0.1
```

### Fixed number of parameters

You can should "fix" the curry to a given length by starting with the number of arguments.

This can be used to make sure the curry ignores optional arguments or to set optional arguments when creating the curry.

``` php
$divider = function ($a, $b, $c = 1) {
    return $a / ($b * $c);
};

$divide10ByProduct = C\curry(2, $divider, 10);
$divideByTripple = C\curry_right(2, $divider, 3);
$divideBy200 = C\curry_right(1, $divider, 10, 20);
```

### Placeholders

The function `__()` gets a special placeholder value used to specify "gaps" within curried functions, allowing partial application of any combination of arguments, regardless of their positions.

```php
use Cypress\Curry as C;

$redact = C\curry('str_replace', C\__(), "***", C\__());

$text = "Jack and Jill went up the hill to fetch a pail of water. Jack fell down and broke his crown and Jill came tumbling after.";

echo $redact(['Jack', 'Jill'], $text);
// *** and *** went up the hill to fetch a pail of water. *** fell down and broke his crown and *** came tumbling after.
```

