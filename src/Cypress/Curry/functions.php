<?php

namespace Cypress\Curry;

use Cypress\Curry\Placeholder;

/**
 * @param callable $callable
 * @return callable
 */
function curry($callable)
{
    if (_number_of_required_params($callable) === 0) {
        return _make_function($callable);
    }
    if (_number_of_required_params($callable) === 1) {
        return _curry_array_args($callable, _rest(func_get_args()));
    }

    return _curry_array_args($callable, _rest(func_get_args()));
}

/**
 * @param $callable
 * @param array $args pass the arguments to be curried as an array
 *
 * @return callable
 */
function curry_args($callable, array $args)
{
    return _curry_array_args($callable, $args);
}

/**
 * @param callable $callable
 * @return callable
 */
function curry_right($callable)
{
    if (_number_of_required_params($callable) < 2)
        return _make_function($callable);
    return _curry_array_args($callable, _rest(func_get_args()), false);
}

/**
 * @param callable $callable
 * @param array $args pass the arguments to be curried as an array
 *
 * @return callable
 */
function curry_right_args($callable, array $args)
{
    return _curry_array_args($callable, $args, false);
}

/**
 * @param callable $callable
 * @param $args
 * @param bool $left
 * @return callable
 */
function _curry_array_args($callable, $args, $left = true)
{
    return function () use ($callable, $args, $left) {
        $newArgs = _merge_args($args, func_get_args(), $left);

        if (_is_fullfilled($callable, $newArgs)) {
            return _execute($callable, $newArgs, $left);
        }
        return _curry_array_args($callable, $newArgs, $left);
    };
}

/**
 * @internal
 * @param $callable
 * @param $args
 * @param $left
 * @return mixed
 */
function _execute($callable, $args, $left)
{
    if (! $left) {
        $args = array_reverse($args);
    }

    $n = _number_of_required_params($callable);

    if (count($args) > $n) {
        $extra = array_splice($args, $left ? $n : 0, count($args) - $n);
        $args = array_merge($args, $left ? $extra : array_reverse($extra));
    }

    return call_user_func_array($callable, $args);
}

/**
 * @internal
 * @param array $args
 * @return array
 */
function _rest(array $args)
{
    return array_slice($args, 1);
}

/**
 * @internal
 * @param callable $callable
 * @param $args
 * @return bool
 */
function _is_fullfilled($callable, $args)
{
    return count($args) >= _number_of_required_params($callable) &&
        !in_array(Placeholder::get(), $args, true);
}

/**
 * @internal
 * @param $callable
 * @return int
 */
function _number_of_required_params($callable)
{
    if (is_array($callable)) {
        $refl = new \ReflectionClass($callable[0]);
        $method = $refl->getMethod($callable[1]);
        return $method->getNumberOfRequiredParameters();
    }
    $refl = new \ReflectionFunction($callable);
    return $refl->getNumberOfRequiredParameters();
}

/**
 * if the callback is an array(instance, method), 
 * it returns an equivalent function for PHP 5.3 compatibility.
 *
 * @internal 
 * @param  callable $callable
 * @return callable
 */
function _make_function($callable)
{
    if (is_array($callable))
        return function() use($callable) {
            return call_user_func_array($callable, func_get_args());
        };
    return $callable;
}

/**
 * Checks if an argument is a placeholder.
 *
 * @internal
 * @param  mixed  $arg
 * @return boolean
 */
function _is_placeholder($arg)
{
    return $arg instanceof Placeholder;
}

/**
 * Merge arguments, replacing placeholders
 */
function _merge_args($args, $newArgs, $left = true)
{
    foreach ($args as &$arg) {
        if (!_is_placeholder($arg))
            continue;

        $arg = array_shift($newArgs);
        if (empty($newArgs))
            break;
    }

    return array_merge($args, $newArgs);
}

/**
 * Gets a special placeholder value used to specify "gaps" within curried 
 * functions, allowing partial application of any combination of arguments, 
 * regardless of their positions. Should be used only for required arguments.
 * When used, optional arguments must be at the end of the arguments list.
 *
 * @return Cypress\Curry\Placeholder
 */
function __()
{
    return Placeholder::get();
}
