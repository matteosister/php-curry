<?php

require __DIR__.'/../vendor/autoload.php';

use Cypress\Curry as C;

$values = array('abc', 'abcd', 'a', 'b');
$patterns = array('^a', 'abcd', 'zzz', 'zzz');

$matchers = array();
for ($i = 0; $i <= 3; $i++) {
    $matchers[] = C\curry('preg_match', '#'.$patterns[$i].'#', $values[$i]);
}

var_dump(array_map(function ($matcher) {
    return 1 === $matcher();
}, $matchers));