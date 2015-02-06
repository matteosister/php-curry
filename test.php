<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 06/02/15
 * Time: 1.10
 */

require __DIR__.'/vendor/autoload.php';

use Cypress\Curry as C;

$chunker = C\curry('array_chunk', ['a', 'b']);
var_dump($chunker(1));
var_dump($chunker(2));