<?php

namespace Cypress\Curry;

/**
 * @param callable $callable
 * @return callable
 */
function curry($callable)
{
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
        if (_is_fullfilled($callable, $args)) {
            return _execute($callable, $args, $left);
        }
        $newArgs = array_merge($args, func_get_args());
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
    return call_user_func_array($callable, $left ? $args : array_reverse($args));
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
    return count($args) === _number_of_required_params($callable);
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
