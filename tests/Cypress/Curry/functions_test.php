<?php

namespace test\Cypress\Curry;

use Cypress\Curry\CurriedFunction;
use Cypress\Curry as C;

class functionsTest extends \PHPUnit_Framework_TestCase
{
    public function test_curry_without_params()
    {
        $simpleFunction = C\curry(function () { return 1; });
        $this->assertEquals(1, $simpleFunction());
    }

    public function test_curry_identity()
    {
        $identity = C\curry(array(new TestSubject(), 'identity'), 1);
        $this->assertEquals(1, $identity(1));
    }

    public function test_curry_args_identity()
    {
        $identity = C\curry_args(array(new TestSubject(), 'identity'), array(1));
        $this->assertEquals(1, $identity(1));
    }

    public function test_curry_with_one_later_param()
    {
        $curriedOne = C\curry(array(new TestSubject(), 'add2'), 1);
        $this->assertInstanceOf('Closure', $curriedOne);
        $this->assertEquals(2, $curriedOne(1));
    }

    public function test_curry_with_two_later_param()
    {
        $curriedTwo = C\curry(array(new TestSubject(), 'add4'), 1, 1);
        $this->assertInstanceOf('Closure', $curriedTwo);
        $this->assertEquals(4, $curriedTwo(1, 1));
    }

    public function test_curry_args_with_two_later_param()
    {
        $curriedTwo = C\curry_args(array(new TestSubject(), 'add4'), array(1, 1));
        $this->assertInstanceOf('Closure', $curriedTwo);
        $this->assertEquals(4, $curriedTwo(1, 1));
    }

    public function test_curry_with_successive_calls()
    {
        $curriedTwo = C\curry(array(new TestSubject(), 'add4'), 1, 1);
        $curriedThree = $curriedTwo(1);
        $this->assertEquals(4, $curriedThree(1));
    }

    public function test_curry_right()
    {
        $divideBy10 = C\curry_right(array(new TestSubject(), 'divide2'), 10);
        $this->assertInstanceOf('Closure', $divideBy10);
        $this->assertEquals(10, $divideBy10(100));
    }

    public function test_curry_right_args()
    {
        $divideBy10 = C\curry_right_args(array(new TestSubject(), 'divide2'), array(10));
        $this->assertInstanceOf('Closure', $divideBy10);
        $this->assertEquals(10, $divideBy10(100));
    }

    public function test_curry_right_immediate()
    {
        $divide3 = C\curry_right(array(new TestSubject(), 'divide3'), 5, 2, 20);
        $this->assertEquals(2, $divide3());
    }

    public function test_curry_right_args_immediate()
    {
        $divide3 = C\curry_right_args(array(new TestSubject(), 'divide3'), array(5, 2, 20));
        $this->assertEquals(2, $divide3());
    }

    public function test_curry_left_immediate()
    {
        $divide3 = C\curry(array(new TestSubject(), 'divide3'), 20, 2, 4);
        $this->assertEquals(2.5, $divide3());
    }

    public function test_curry_three_times()
    {
        $divideBy5 = C\curry(array(new TestSubject(), 'divide3'), 100);
        $divideBy10And5 = $divideBy5(10);
        $this->assertEquals(2, $divideBy10And5(5));
    }

    public function test_curry_right_three_times()
    {
        $divideBy5 = C\curry_right(array(new TestSubject(), 'divide3'), 5);
        $divideBy10And5 = $divideBy5(10);
        $this->assertEquals(2, $divideBy10And5(100));
    }

    public function test_curry_right_args_three_times()
    {
        $divideBy5 = C\curry_right_args(array(new TestSubject(), 'divide3'), array(5));
        $divideBy10And5 = $divideBy5(10);
        $this->assertEquals(2, $divideBy10And5(100));
    }

    public function test_rest()
    {
        $this->assertEquals(array(1), C\_rest(array(1, 1)));
        $this->assertEquals(array('a', 'b'), C\_rest(array(1, 'a', 'b')));
        $this->assertEquals(array(), C\_rest(array(1)));
        $this->assertEquals(array(), C\_rest(array()));
    }

    /**
     * @dataProvider provider_is_fullfilled
     */
    public function test_is_fullfilled($isFullfilled, $args, $callable)
    {
        $this->assertSame($isFullfilled, C\_is_fullfilled($callable, $args));
    }

    public function provider_is_fullfilled()
    {
        return array(
            array(false, array(), function ($a) {}),
            array(true, array(), function () {}),
            array(true, array(1), function ($a) {}),
            array(false, array(1), function ($a, $b) {}),
            array(false, array(1), array(new TestSubject(), 'add2')),
            array(true, array(1, 2), array(new TestSubject(), 'add2')),
            array(true, array('aaa', 'a'), 'strpos'),
        );
    }
}

class TestSubject
{
    public function identity($a) {
        return $a;
    }

    public function add2($a, $b) {
        return $a + $b;
    }

    public function divide2($a, $b) {
        return $a / $b;
    }

    public function divide3($a, $b, $c) {
        return $a / $b / $c;
    }

    public function add3($a, $b, $c)
    {
        return $a + $b + $c;
    }

    public function add4($a, $b, $c, $d)
    {
        return $a + $b + $c + $d;
    }
}