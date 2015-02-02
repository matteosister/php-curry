<?php

namespace test\Cypress\Curry;

use Cypress\Curry\CurriedFunction;

class CurriedFunctionTest extends \PHPUnit_Framework_TestCase
{
    public function test_curried_lambda()
    {
        $add = CurriedFunction::left(function ($a, $b) { return $a + $b; });
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add(1));
        $this->assertEquals(2, $add(1, 1));
    }

    public function test_curried_object_method()
    {
        $add = CurriedFunction::left(array(new TestSubject(), 'add2'));
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add(1));
        $this->assertEquals(2, $add(1, 1));
    }

    public function test_curried_function_by_name()
    {
        $strpos = CurriedFunction::left('strpos');
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos('test'));
        $this->assertEquals(1, $strpos('test', 'e'));
    }

    public function test_curried_function_by_name_and_fixed_length()
    {
        $strpos = CurriedFunction::leftFixed('strpos', array(), 2);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos('test'));
        $this->assertEquals(1, $strpos('test', 'e'));
    }

    public function test_right_curried_function_by_name_and_fixed_length()
    {
        $strpos = CurriedFunction::rightFixed('strpos', array(), 2);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos('e'));
        $this->assertEquals(1, $strpos('e', 'test'));
    }
}

class TestSubject
{
    public function add2($a, $b) {
        return $a + $b;
    }

    public function divide2($a, $b) {
        return $a / $b;
    }

    public function add3($a, $b, $c)
    {
        return $a + $b + $c;
    }
}