<?php

$input = [
  '123 -> x',
  '456 -> y',
  'x AND y -> d',
  'x OR y -> e',
  'x LSHIFT 2 -> f',
  'y RSHIFT 2 -> g',
  'NOT x -> h',
  'NOT y -> i'
];

$circuit = [];
foreach($input as $in) {
  if (!preg_match('/([\w ]+) -> (\w+)/', $in, $match)) continue;
  $code = $match[1];
  $to = $match[2];

  if (is_numeric($code)) {
    $circuit[$to] = intval($code) & 0xFFFF;
  }
  elseif (preg_match('/NOT (\w+)/', $code, $match)) {
    if (is_numeric($match[1])) {
      $val = $match[1];
    } else {
      if (empty($circuit[$match[1]])) {
        var_dump($circuit[$match[1]]);
        die('Not Set: '. $in);
      }
      $val = $circuit[$match[1]];
    }
    $circuit[$to] = ~intval($val) & 0xFFFF;
  } elseif(preg_match('/(\w+) (AND|OR|LSHIFT|RSHIFT) (\w+)/', $code, $match)) {
    //todo
  } else {
    die ('Invalid code '. $code);
  }
}
ksort($circuit);
var_dump($circuit);
