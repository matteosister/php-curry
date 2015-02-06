<?php

namespace Cypress\Curry;

/**
 * @param callable $callable
 * @return CurriedFunction
 */
function curry(callable $callable)
{
    return CurriedFunction::left($callable, array_slice(func_get_args(), 1));
}

/**
 * @param int      $argsNumber
 * @param callable $callable
 *
 * @return CurriedFunction
 */
function curry_fixed($argsNumber, callable $callable)
{
    return CurriedFunction::leftFixed($callable, array_slice(func_get_args(), 2), $argsNumber);
}

/**
 * @param callable $callable
 * @return CurriedFunction
 */
function curry_right(callable $callable)
{
    return CurriedFunction::right($callable, array_slice(func_get_args(), 1));
}

/**
 * @param $argsNumber
 * @param callable $callable
 * @return CurriedFunction
 */
function curry_right_fixed($argsNumber, callable $callable)
{
    return CurriedFunction::right($callable, array_slice(func_get_args(), 2), $argsNumber);
}
