<?php

namespace Cypress\Curry;

/**
 * Addition; `+` operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_a979ef10cc6f6a36df6b8a323307ee3bb2e2db9c($a, $b)
{
    return $a + $b;
}

/**
 * Subtraction; `-` operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_3bc15c8aae3e4124dd409035f32ea2fd6835efc9($a, $b)
{
    return $a - $b;
}

/**
 * Multiplication; `*` operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_df58248c414f342c81e056b40bee12d17a08bf61($a, $b)
{
    return $a * $b;
}

/**
 * Division; `/` operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_42099b4af021e53fd8fd4e056c2568d7c2e3ffa8($a, $b)
{
    return $a / $b;
}

/**
 * Modulo; `%` operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_4345cb1fa27885a8fbfe7c0c830a592cc76a552b($a, $b)
{
    return $a % $b;
}

/**
 * Exponentiation; `**` operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_bc2f74c22f98f7b6ffbc2f67453dbfa99bce9a32($a, $b)
{
    return $a ** $b;
}


/**
 * Equal; '==' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_6947818ac409551f11fbaa78f0ea6391960aa5b8($a, $b)
{
    return $a == $b;
}

/**
 * Identical; '===' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_b64cc2760536699c09c33fd0c38b16350e500872($a, $b)
{
    return $a === $b;
}

/**
 * Not equal; '!=' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_d066fc085455ed98db6ac1badc818019c77c44ab($a, $b)
{
    return $a != $b;
}

/**
 * Not identical; '!==' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_b7192c948f69d7776ba52c9d03f8632ec6afe9de($a, $b)
{
    return $a !== $b;
}

/**
 * Less than; '<' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_c4dd3c8cdd8d7c95603dd67f1cd873d5f9148b29($a, $b)
{
    return $a < $b;
}

/**
 * Greater than; '>' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_091385be99b45f459a231582d583ec9f3fa3d194($a, $b)
{
    return $a > $b;
}

/**
 * Less than or equal to; '<=' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_8a681a2f041f4625cceacf20f0cf8ebf4248b5f1($a, $b)
{
    return $a <= $b;
}

/**
 * Greater than or equal to; '>=' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function _operator_6c22e68f3b484db9779ac9e86488c2648313c410($a, $b)
{
    return $a >= $b;
}

/**
 * Ternary; '?' operator ($if ? $then : $else)
 *
 * @internal
 * @param bool  $if
 * @param mixed $then
 * @param mixed $else
 * @return mixed
 */
function _operator_5bab61eb53176449e25c2c82f172b82cb13ffb9d($if, $then, $else)
{
    return $if ? $then : $else;
}

/**
 * Elvis; '?:' operator ($select ?: $else)
 *
 * @internal
 * @param mixed $select
 * @param mixed $else
 * @return mixed
 */
function _operator_e305f01faf8d7245a465629effccc67bc3d32ef7($select, $else)
{
    return $select ?: $else;
}

/**
 * Concatenation; '.' operator
 *
 * @internal
 * @param string $a
 * @param string $b
 * @return string
 */
function _operator_3a52ce780950d4d969792a2559cd519d7ee8c727($a, $b)
{
    return $a . $b;
}

/**
 * Logical and; '&&' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_436f27a6ccf1ee52cf01c9775136ff5ecb4f3a72($a, $b)
{
    return $a && $b;
}

/**
 * Logical and; 'and' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_and($a, $b)
{
    return $a && $b;
}

/**
 * Logical or; '||' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_c65f37b2cb1ae26c89e9b4f26e2ca9e9cde4ae5b($a, $b)
{
    return $a || $b;
}

/**
 * Logical or; 'or' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_or($a, $b)
{
    return $a || $b;
}

/**
 * Logical xor; 'xor' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_xor($a, $b)
{
    return $a xor $b;
}

/**
 * Logical not; '!' operator
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_0ab8318acaf6e678dd02e2b5c343ed41111b393d($a)
{
    return !$a;
}

/**
 * Logical not (alias)
 *
 * @internal
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function _operator_not($a)
{
    return !$a;
}


/**
 * Bitwise and; '&' operator
 *
 * @internal
 * @param int $a
 * @param int $b
 * @return int
 */
function _operator_7c4d33785daa5c2370201ffa236b427aa37c9996($a, $b)
{
    return $a & $b;
}

/**
 * Bitwise or; '|' operator
 *
 * @internal
 * @param int $a
 * @param int $b
 * @return int
 */
function _operator_3eb416223e9e69e6bb8ee19793911ad1ad2027d8($a, $b)
{
    return $a | $b;
}

/**
 * Bitwise xor; '^' operator
 *
 * @internal
 * @param int $a
 * @param int $b
 * @return int
 */
function _operator_5e6f80a34a9798cafc6a5db96cc57ba4c4db59c2($a, $b)
{
    return $a ^ $b;
}

/**
 * Bitwise not; '~' operator
 *
 * @internal
 * @param int $a
 * @return int
 */
function _operator_fb3c6e4de85bd9eae26fdc63e75f10a7f39e850e($a)
{
    return ~$a;
}

/**
 * Bitwise shift left; '<<' operator
 *
 * @internal
 * @param int $a
 * @param int $b
 * @return int
 */
function _operator_79047441987fa5937e857918d596ca65a8994f05($a, $b)
{
    return $a << $b;
}

/**
 * Bitwise shift right; '>>' operator
 *
 * @internal
 * @param int $a
 * @param int $b
 * @return int
 */
function _operator_74562623d15859b6a47065e0f98ce1202fb56506($a, $b)
{
    return $a >> $b;
}
