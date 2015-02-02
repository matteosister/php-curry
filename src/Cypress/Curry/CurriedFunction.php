<?php

namespace Cypress\Curry;

class CurriedFunction
{
    const CURRY_L = 'l';
    const CURRY_R = 'r';

    /**
     * @var callable
     */
    private $callable;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var array
     */
    private $args;

    /**
     * @var int
     */
    private $totalArgs;

    /**
     * @param $callable
     * @param string $direction
     * @param array $args
     * @param null $totalArgs
     */
    private function __construct($callable, $direction, array $args = array(), $totalArgs = null)
    {
        $this->totalArgs = $totalArgs;
        $this->args = $args;
        $this->direction = $direction;
        $this->callable = $callable;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s curried version of function "%s", binded params: %s',
            self::CURRY_L === $this->direction ? 'left' : 'right',
            is_array($this->callable) ? $this->callable[1] : $this->callable,
            implode(', ', $this->args)
        );
    }

    /**
     * Left curry constructor
     *
     * @param callable $callable a callable
     * @param array    $args     function arguments
     *
     * @return CurriedFunction
     */
    public static function left($callable, array $args = array())
    {
        return new CurriedFunction($callable, self::CURRY_L, $args);
    }

    /**
     * Left curried
     *
     * @param callable $callable a callable
     * @param array $args        function arguments
     * @param null $totalArgs    total arguments
     *
     * @return CurriedFunction
     */
    public static function leftFixed($callable, array $args = array(), $totalArgs = null)
    {
        return new CurriedFunction($callable, self::CURRY_L, $args, $totalArgs);
    }

    /**
     * @param callable $callable a callable
     * @param array $args        function arguments
     *
     * @return CurriedFunction
     */
    public static function right($callable, array $args = array())
    {
         return new CurriedFunction($callable, self::CURRY_R, $args);
    }

    /**
     * @param callable $callable  a callable
     * @param array $args         function arguments
     * @param null|int $totalArgs fix the curry at the given argument number
     * @return CurriedFunction
     */
    public static function rightFixed($callable, array $args = array(), $totalArgs = null)
    {
        return new CurriedFunction($callable, self::CURRY_R, $args, $totalArgs);
    }

    /**
     * @return int
     */
    private function totalArgs()
    {
        if (! is_null($this->totalArgs)) {
            return $this->totalArgs;
        }
        if (is_array($this->callable)) {
            $refl = new \ReflectionClass($this->callable[0]);
            $method = $refl->getMethod($this->callable[1]);
            return $method->getNumberOfRequiredParameters();
        }
        return $this->getReflection()->getNumberOfRequiredParameters();
    }

    /**
     * @return \ReflectionFunction
     */
    private function getReflection()
    {
        return new \ReflectionFunction($this->callable);
    }

    /**
     * @return bool
     */
    private function isLeftCurried()
    {
        return self::CURRY_L === $this->direction;
    }

    /**
     * True if the function has all the parameters and it's ready to fire
     *
     * @return bool
     */
    private function isFullfilled()
    {
        return $this->totalArgs() === count($this->args);
    }

    /**
     * Invoker
     *
     * @return $this|CurriedFunction|mixed
     */
    public function __invoke()
    {
        if ($this->isFullfilled()) {
            return $this->execute($this->args);
        }
        if (0 === func_num_args()) {
            return $this;
        }
        $newArgs = $this->args;
        foreach (func_get_args() as $arg) {
            array_push($newArgs, $arg);
            if ($this->totalArgs() === count($newArgs)) {
                return $this->execute($newArgs);
            }
        }
        return new self($this->callable, $this->direction, $newArgs);
    }

    /**
     * @param $args
     * @return mixed
     */
    private function execute($args)
    {
        return call_user_func_array($this->callable, $this->isLeftCurried() ? $args : array_reverse($args));
    }
}
