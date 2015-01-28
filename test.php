<?php

require __DIR__.'/vendor/autoload.php';

use React\Partial as P;
use Cypress\Curry as C;

function divide($a, $b, $c) {
    return $a / $b / $c;
}

$divideRight = C\curryRight('divide', 10, 10);

$divideRight2 = $divideRight(100);
var_dump($divideRight2);