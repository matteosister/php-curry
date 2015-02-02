<?php

namespace Cypress\Curry;

/**
 * @param $callable
 * @return CurriedFunction
 */
function curry(callable $callable)
{
    return CurriedFunction::left($callable, array_slice(func_get_args(), 1));
}

/**
 * @param $callable
 * @return CurriedFunction
 */
function curry_right(callable $callable)
{
    return CurriedFunction::right($callable, array_slice(func_get_args(), 1));
}
