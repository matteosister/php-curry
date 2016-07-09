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

### Optional parameters

Optional parameters and currying do not play very nicely together. This library excludes optional parameters by default.

``` php
$haystack = "haystack";
$searches = ['h', 'a', 'z'];
$strpos = C\curry('strpos', $haystack); // You can pass function as string too!
var_dump(array_map($strpos, $searches)); // output [0, 1, false]
```

But strpos has an optional $offset parameter that by default has not been considered.

If you want to take this optional $offset parameter into account you should "fix" the curry to a given length.

``` php
$haystack = "haystack";
$searches = ['h', 'a', 'z'];
$strpos = C\curry_fixed(3, 'strpos', $haystack);
$finders = array_map($strpos, $searches);
var_dump(array_map(function ($finder) {
    return $finder(2);
}, $finders)); // output [false, 5, false]
```

*curry_right* has its own fixed version named *curry_right_fixed*

### Placeholders

The function `__()` gets a special placeholder value used to specify "gaps" within curried functions, allowing partial application of any combination of arguments, regardless of their positions.

```php
$add = function($x, $y)
{ 
	return $x + $y; 
};
$reduce = C\curry('array_reduce');
$sum = $reduce(C\__(), $add);

echo $sum([1, 2, 3, 4], 0); // output 10
```

**Notes**:

- Placeholders should be used only for required arguments.

- When used, optional arguments must be at the end of the arguments list.
