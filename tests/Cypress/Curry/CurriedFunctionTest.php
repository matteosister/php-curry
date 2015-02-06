<?php

namespace test\Cypress\Curry;

use Cypress\Curry\CurriedFunction;
use Cypress\Curry as C;

class CurriedFunctionTest extends \PHPUnit_Framework_TestCase
{
    public function test_curried_lambda()
    {
        $add = C\curry(function ($a, $b) { return $a + $b; });
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add(1));
        $this->assertEquals(2, $add(1, 1));
    }

    public function test_curried_lambda_with_functions()
    {
        $add = C\curry(function ($a, $b) { return $a + $b; });
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add(1));
        $this->assertEquals(2, $add(1, 1));
    }

    public function test_curried_right_lambda_with_functions()
    {
        $subtract = C\curry_right(function ($a, $b) { return $a - $b; });
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $subtract);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $subtract(10));
        $this->assertEquals(90, $subtract(10, 100));
    }

    public function test_curried_object_method()
    {
        $add = C\curry(array(new TestSubject(), 'add2'));
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $add(1));
        $this->assertEquals(2, $add(1, 1));
    }

    public function test_curried_function_by_name()
    {
        $strpos = C\curry('strpos');
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos('test'));
        $this->assertEquals(1, $strpos('test', 'e'));
    }

    public function test_right_curried_function_by_name()
    {
        $strposR = C\curry_right('strpos');
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strposR);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strposR('test'));
        $this->assertEquals(1, $strposR('e', 'test'));
    }

    public function test_curried_function_by_name_and_fixed_length()
    {
        $strpos = C\curry_fixed(2, 'strpos');
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos('test'));
        $this->assertEquals(1, $strpos('test', 'e'));
    }

    public function test_right_curried_function_by_name_and_fixed_length()
    {
        $strpos = C\curry_right_fixed(2, 'strpos');
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos);
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos());
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $strpos('e'));
        $this->assertEquals(1, $strpos('e', 'test'));
    }

    public function test_function_without_params()
    {
        $return0 = C\curry(function () { return 0; });
        $this->assertInstanceOf('Cypress\Curry\CurriedFunction', $return0);
        $this->assertEquals(0, $return0());
    }

    public function test_toString()
    {
        $strpos = C\curry_fixed(2, 'strpos');
        $this->assertContains('left curried', $strpos->__toString());
        $this->assertContains('strpos', $strpos->__toString());
        $this->assertContains('test_string', $strpos('test_string')->__toString());
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