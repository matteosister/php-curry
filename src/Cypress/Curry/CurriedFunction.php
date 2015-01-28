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
     * @param callable $callable
     * @param string   $direction
     * @param array    $args
     */
    private function __construct(callable $callable, $direction, array $args = array())
    {
        $this->args = $args;
        $this->direction = $direction;
        $this->callable = $callable;
    }

    /**
     * @param callable $callable
     * @param array $args
     * @return CurriedFunction
     */
    public static function left(callable $callable, array $args = array())
    {
        return new CurriedFunction($callable, self::CURRY_L, $args);
    }

    /**
     * @param callable $callable
     * @param array $args
     * @return CurriedFunction
     */
    public static function right(callable $callable, array $args = array())
    {
         return new CurriedFunction($callable, self::CURRY_R, $args);
    }

    /**
     * @return int
     */
    private function totalArgs()
    {
        return count($this->getReflection()->getParameters());
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
     * @return bool
     */
    private function isFullfilled()
    {
        return $this->totalArgs() === count($this->args);
    }

    /**
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
    public function execute($args)
    {
        return call_user_func_array($this->callable, $this->isLeftCurried() ? $args : array_reverse($args));
    }
}