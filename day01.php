<?php

$input = file_get_contents('input/day01.txt');
$parts = str_split($input);
$floor = 0;
$plus = 0;
$minus = 0;
$atMinus1 = false;
foreach($parts as $pos => $part) {
  if ($part == '(') { $floor++; $plus++; }
  elseif ($part == ')') { $floor--; $minus++; }

  if (!$atMinus1 && $floor == '-1') {
    print ('At -1 in pos '. ($pos+1) ."\n");
    $atMinus1 = true;
  }
}

var_dump(['floor' =>  $floor, 'plus' => $plus, 'minus' => $minus]);
