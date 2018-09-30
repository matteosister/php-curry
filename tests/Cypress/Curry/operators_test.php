<?php

namespace test\Cypress\Curry;

use Cypress\Curry as C;
use PHPUnit\Framework\TestCase;

class operatorsTest extends TestCase
{
    function test_addition_operator()
    {
        $this->assertEquals(7, C\curry('+')(3, 4));
        $this->assertEquals(11, C\curry('+', 5)(6));
        $this->assertEquals(13, C\curry('+')(7)(6));
        $this->assertEquals(17, C\curry('+', C\__(), -13)(30));
        $this->assertEquals(['a' => 'e', 'I' => 'V'], C\curry('+', ['a' => 'e'])(['I' => 'V']));
    }

    function test_substraction_operator()
    {
        $this->assertEquals(3, C\curry('-')(7, 4));
        $this->assertEquals(5, C\curry('-', 11)(6));
        $this->assertEquals(7, C\curry('-')(13)(6));
        $this->assertEquals(-13, C\curry('-', C\__(), 30)(17));
    }

    function test_multiplication_operator()
    {
        $this->assertEquals(12, C\curry('*')(3, 4));
        $this->assertEquals(30, C\curry('*', 5)(6));
        $this->assertEquals(42, C\curry('*')(7)(6));
        $this->assertEquals(-390, C\curry('*', C\__(), -13)(30));
    }

    function test_devision_operator()
    {
        $this->assertEquals(3, C\curry('/')(12, 4));
        $this->assertEquals(5.5, C\curry('/', 22)(4));
        $this->assertEquals(10, C\curry('/')(100)(10));
        $this->assertEquals(-7, C\curry('/', C\__(), 7)(-49));
    }

    function test_modulo_operator()
    {
        $this->assertEquals(0, C\curry('%')(12, 4));
        $this->assertEquals(5, C\curry('%', 53)(8));
        $this->assertEquals(7, C\curry('%')(67)(10));
        $this->assertEquals(-13, C\curry('%', C\__(), 20)(-33));
    }

    function test_exponentiation_operator()
    {
        $this->assertEquals(25, C\curry('**', 5)(2));
        $this->assertEquals(25, C\curry('**', 5)(2));
        $this->assertEquals(1024, C\curry('**')(4)(5));
        $this->assertEquals(-64, C\curry('**', C\__(), 3)(-4));
    }


    function test_equal_operator()
    {
        $this->assertTrue(C\curry('==')('foo', 'foo'));
        $this->assertTrue(C\curry('==', 'bar')('bar'));
        $this->assertFalse(C\curry('==')('foo')('bar'));
        $this->assertTrue(C\curry('==', C\__(), 42)('42'));
    }

    function test_identical_operator()
    {
        $this->assertTrue(C\curry('===')('foo', 'foo'));
        $this->assertTrue(C\curry('===', 'bar')('bar'));
        $this->assertFalse(C\curry('===')('foo')('bar'));
        $this->assertFalse(C\curry('===', C\__(), 42)('42'));
    }

    function test_not_equal_operator()
    {
        $this->assertFalse(C\curry('!=')('foo', 'foo'));
        $this->assertFalse(C\curry('!=', 'foo')('foo'));
        $this->assertTrue(C\curry('!=')('foo')('bar'));
        $this->assertFalse(C\curry('!=', C\__(), 42)('42'));
    }

    function test_not_identical_operator()
    {
        $this->assertFalse(C\curry('!==')('foo', 'foo'));
        $this->assertFalse(C\curry('!==', 'bar')('bar'));
        $this->assertTrue(C\curry('!==')('foo')('bar'));
        $this->assertTrue(C\curry('!==', C\__(), 42)('42'));
    }

    function test_less_than_operator()
    {
        $this->assertTrue(C\curry('<')(3, 10));
        $this->assertTrue(C\curry_right('<')('foo')('bar'));
        $this->assertFalse(C\curry_right('<', 42)(42));
        $this->assertFalse(C\curry('<', C\__(), 42)(100));
    }

    function test_greater_than_operator()
    {
        $this->assertFalse(C\curry('>')(3, 10));
        $this->assertFalse(C\curry_right('>')('foo')('bar'));
        $this->assertFalse(C\curry_right('>', 42)(42));
        $this->assertTrue(C\curry('>', C\__(), 42)(100));
    }

    function test_less_than_or_equal_to_operator()
    {
        $this->assertTrue(C\curry('<=')(3, 10));
        $this->assertTrue(C\curry_right('<=')('foo')('bar'));
        $this->assertTrue(C\curry_right('<=', 42)(42));
        $this->assertFalse(C\curry('<=', C\__(), 42)(100));
    }

    function test_greater_than_or_equal_operator()
    {
        $this->assertFalse(C\curry('>=')(3, 10));
        $this->assertFalse(C\curry_right('>=')('foo')('bar'));
        $this->assertTrue(C\curry_right('>=', 42)(42));
        $this->assertTrue(C\curry('>=', C\__(), 42)(100));
    }


    function test_ternary_operator()
    {
        $this->assertEquals(7, C\curry('?', C\__(), 7, 9)(true));
        $this->assertEquals(9, C\curry('?', C\__(), 7, 9)(false));
        $this->assertEquals(7, C\curry_right('?', C\__(), C\__(), 9)(7)(true));
    }

    function test_elvis_operator()
    {
        $this->assertEquals(7, C\curry('?:', C\__(), 100)(7));
        $this->assertEquals(100, C\curry('?:', C\__(), 100)(0));

        $this->assertEquals(7, C\curry('?:', 7)(9));
        $this->assertEquals(7, C\curry('?:', 0)(7));
    }

    function test_concatenation_operator()
    {
        $this->assertEquals('ab', C\curry('.')('a', 'b'));
        $this->assertEquals('ab', C\curry('.', 'a')('b'));
        $this->assertEquals('ab', C\curry('.')('a')('b'));
        $this->assertEquals('ab', C\curry('.', C\__(), 'b')('a'));
    }


    function and_provider()
    {
        return [['&&'], ['and']];
    }

    /**
     * @dataProvider and_provider
     */
    function test_and_operator($op)
    {
        $this->assertFalse(C\curry($op)(false, false));
        $this->assertFalse(C\curry($op, true)(false));
        $this->assertFalse(C\curry($op)(false)(true));
        $this->assertTrue(C\curry($op, C\__(), true)(true));
    }

    function or_provider()
    {
        return [['||'], ['or']];
    }

    /**
     * @dataProvider or_provider
     */
    function test_or_operator($op)
    {
        $this->assertFalse(C\curry($op)(false, false));
        $this->assertTrue(C\curry($op, true)(false));
        $this->assertTrue(C\curry($op)(false)(true));
        $this->assertTrue(C\curry($op, C\__(), true)(true));
    }

    function test_xor_operator()
    {
        $this->assertFalse(C\curry('xor')(false, false));
        $this->assertTrue(C\curry('xor', true)(false));
        $this->assertTrue(C\curry('xor')(false)(true));
        $this->assertFalse(C\curry('xor', C\__(), true)(true));
    }

    function not_provider()
    {
        return [['!'], ['not']];
    }

    /**
     * @dataProvider not_provider
     */
    function test_not_operator($op)
    {
        $this->assertTrue(C\curry($op)(false));
        $this->assertFalse(C\curry($op, C\__())(1));
    }


    function test_bitwise_and()
    {
        $this->assertEquals(0b10100000, C\curry('&')(0b10101010)(0b11110000));
        $this->assertEquals(0b00001010, C\curry('&', C\__(), 0b00001111)(0b10101010));
    }

    function test_bitwise_or()
    {
        $this->assertEquals(0b11111010, C\curry('|')(0b10101010)(0b11110000));
        $this->assertEquals(0b10101111, C\curry('|', C\__(), 0b00001111)(0b10101010));
    }

    function test_bitwise_xor()
    {
        $this->assertEquals(0b01011010, C\curry('^')(0b10101010)(0b11110000));
        $this->assertEquals(0b10100101, C\curry('^', C\__(), 0b00001111)(0b10101010));
    }

    function test_bitwise_not()
    {
        $this->assertEquals(~0b10100000, C\curry('~')(0b10100000));
    }

    function test_bitwise_shift_left()
    {
        $this->assertEquals(0b10100000, C\curry('<<')(0b00001010)(4));
        $this->assertEquals(0b10100000, C\curry('<<', C\__(), 4)(0b00001010));
    }

    function test_bitwise_shift_right()
    {
        $this->assertEquals(0b00001010, C\curry('>>')(0b10100000)(4));
        $this->assertEquals(0b00001010, C\curry('>>', C\__(), 4)(0b10100000));
    }


    function test_operator_args()
    {
        $this->assertEquals(3, C\curry_args('-', [5])(2));
    }

    function test_operator_right_args()
    {
        $this->assertEquals(3, C\curry_right_args('-', [2])(5));
    }


    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Operator '=' can't be used as curry function
     */
    function test_assignment_operator()
    {
        C\curry('=')('foo', 'bar');
    }
}
