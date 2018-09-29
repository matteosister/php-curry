<?php

namespace test\Cypress\Curry;

use Cypress\Curry as C;
use PHPUnit\Framework\TestCase;

class functionsTest extends TestCase
{
    public function test_curry_without_params()
    {
        $simpleFunction = C\curry(function () { return 1; });
        $this->assertEquals(1, $simpleFunction());
    }

    public function test_curry_constant()
    {
        $constant = C\curry(array(new TestSubject(), 'constant'));
        $this->assertEquals(1, $constant());
    }

    public function test_curry_identity()
    {
        $identity = C\curry(array(new TestSubject(), 'identity'), 1);
        $this->assertEquals(1, $identity());
    }

    public function test_curry_identity_with_additional_arg()
    {
        $identity = C\curry(array(new TestSubject(), 'identity'), 1);
        $this->assertEquals(1, $identity(10));
    }

    public function test_curry_identity_function()
    {
        $func = C\curry(function ($v) { return $v; }, 'test string');
        $this->assertEquals('test string', $func());
    }

    public function test_curry_args_identity_function()
    {
        $func = C\curry_args(function ($v) { return $v; }, ['test string']);
        $this->assertEquals('test string', $func());
    }

    public function test_curry_args_identity()
    {
        $identity = C\curry_args(array(new TestSubject(), 'identity'), array(1));
        $this->assertEquals(1, $identity());
    }

    public function test_curry_with_one_later_param()
    {
        $curriedOne = C\curry(array(new TestSubject(), 'add2'), 1);
        $this->assertInstanceOf('Closure', $curriedOne);
        $this->assertEquals(2, $curriedOne(1));
    }

    public function test_curry_with_additional_arg()
    {
        $curriedOne = C\curry(array(new TestSubject(), 'add2'), 1);
        $this->assertInstanceOf('Closure', $curriedOne);
        $this->assertEquals(3, $curriedOne(2, 7));
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

    public function test_curry_right_additional_arg()
    {
        $divideBy10 = C\curry_right(array(new TestSubject(), 'divide2'), 10);
        $this->assertInstanceOf('Closure', $divideBy10);
        $this->assertEquals(10, $divideBy10(100, 20));
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

    public function test_curry_using_func_get_args()
    {

        $fnNoArgs = function () { return func_get_args(); };
        $curried = C\curry($fnNoArgs);
        $curriedRight = C\curry_right($fnNoArgs);

        $this->assertEquals(array(), $fnNoArgs());
        $this->assertEquals(array(), $curried());
        $this->assertEquals(array(), $curriedRight());

        $this->assertEquals(array(1), $fnNoArgs(1));
        $this->assertEquals(array(1), $curried(1));
        $this->assertEquals(array(1), $curriedRight(1));

        $this->assertEquals(array(1, 2, 'three'), $fnNoArgs(1, 2, 'three'));
        $this->assertEquals(array(1, 2, 'three'), $curried(1, 2, 'three'));
        $this->assertEquals(array(1, 2, 'three'), $curriedRight(1, 2, 'three'));

        $fnOneArg = function ($x) { return func_get_args(); };
        $curried = C\curry($fnOneArg);
        $curriedRight = C\curry_right($fnOneArg);

        $this->assertEquals(array(1), $fnOneArg(1));
        $this->assertEquals(array(1), $curried(1));
        $this->assertEquals(array(1), $curriedRight(1));

        $this->assertEquals(array(1, 2, 'three'), $fnOneArg(1, 2, 'three'));
        $this->assertEquals(array(1, 2, 'three'), $curried(1, 2, 'three'));
        $this->assertEquals(array(1, 2, 'three'), $curriedRight(1, 2, 'three'));

        $fnTwoArgs = function ($x, $y) { return func_get_args(); };
        $curried = C\curry($fnTwoArgs);
        $curriedRight = C\curry_right($fnTwoArgs);

        $curriedOne = $curried(1); 
        $curriedRightOne = $curriedRight(2);

        $this->assertEquals(array(1, 2), $fnTwoArgs(1, 2));
        $this->assertEquals(array(1, 2), $curried(1, 2));
        $this->assertEquals(array(1, 2), $curriedRight(2, 1));

        $this->assertEquals(array(1, 2, 'three'), $fnTwoArgs(1, 2, 'three'));
        $this->assertEquals(array(1, 2, 'three'), $curried(1, 2, 'three'));
        $this->assertEquals(array(1, 2, 'three'), $curriedRight(2, 1, 'three'));

        $this->assertEquals(array(1, 2), $curriedOne(2));
        $this->assertEquals(array(1, 2), $curriedRightOne(1));

        $this->assertEquals(array(1, 2, 'three'), $curriedOne(2, 'three'));
        $this->assertEquals(array(1, 2, 'three', 'IV'), $curriedRightOne(1, 'three', 'IV'));
    }

    public function test_curry_with_placeholders()
    {
        $minus = C\curry(function ($x, $y) { return $x - $y; });
        $decrement = $minus(C\__(), 1);

        $this->assertEquals(9, $decrement(10));

        $introduce = C\curry(function($name, $age, $job, $details = '') {
            return "{$name}, {$age} years old, is a {$job} {$details}";
        });

        $introduceDeveloper = $introduce(C\__(), C\__(), 'Developer');
        $this->assertEquals("Foo, 20 years old, is a Developer ", $introduceDeveloper('Foo', 20));

        $introduceOld = $introduce(C\__(), 99, C\__());
        $this->assertEquals("Foo, 99 years old, is a Developer and Cooker as well", $introduceOld('Foo', 'Developer', 'and Cooker as well'));

        $introduceOldDeveloper = $introduceDeveloper(C\__(), 99, C\__());
        $this->assertEquals("Foo, 99 years old, is a Developer cool !", $introduceOldDeveloper('Foo', 'cool !'));

        $reduce = C\curry('array_reduce');
        $add = function($x, $y){ return $x + $y; };
        $sum = $reduce(C\__(), $add);

        $this->assertEquals(10, $sum(array(1, 2, 3, 4), 0));
    }

    public function test_curry_with_placeholders_and_optional_arg()
    {
        $subtractMulti = function($a, $b, $c = 1) {
            return $a - ($b * $c);
        };

        $subtractDoubleFrom = C\curry($subtractMulti, C\__(), C\__(), 2);
        $this->assertEquals(40, $subtractDoubleFrom(100, 30));

        $subtractDoubleFrom100 = $subtractDoubleFrom(100);
        $this->assertInstanceOf('Closure', $subtractDoubleFrom100);
        $this->assertEquals(40, $subtractDoubleFrom100(30));

        $subtractDoubleFrom = C\curry($subtractMulti, C\__(), C\__(), 2);
        $this->assertEquals(40, $subtractDoubleFrom(100, 30, 999));
    }

    public function test_curry_right_with_placeholders_and_optional_arg()
    {
        $subtractMulti = function($a, $b, $c = 1) {
            return $a - ($b * $c);
        };

        $subtractDouble = C\curry_right($subtractMulti, C\__(), C\__(), 2);
        $this->assertEquals(40, $subtractDouble(30, 100));

        $subtract60 = $subtractDouble(30);
        $this->assertInstanceOf('Closure', $subtract60);
        $this->assertEquals(40, $subtract60(100));

        $subtractDouble = C\curry_right($subtractMulti, C\__(), C\__(), 2);
        $this->assertEquals(40, $subtractDouble(30, 100, 999));
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

    public function test_placeholder()
    {
        $placeholder = C\Placeholder::get();

        $this->assertSame($placeholder, C\Placeholder::get());
        $this->assertEquals('__', (string)$placeholder);
    }
}

class TestSubject
{
    public function constant() {
        return 1;
    }

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