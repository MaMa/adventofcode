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

function num_or_val($in) {
  global $circuit;
  if (is_numeric($in)) {
    return $in & 0xFFFF;
  } else {
    if (empty($circuit[$in])) {
      var_dump($circuit[$match[1]]);
      die('Not Set: '. $in);
    }
    return $circuit[$in];
  }
}

foreach($input as $in) {
  if (!preg_match('/([\w ]+) -> (\w+)/', $in, $match)) continue;
  $code = $match[1];
  $to = $match[2];

  if (is_numeric($code)) {
    $circuit[$to] = intval($code) & 0xFFFF;
  }
  elseif (preg_match('/NOT (\w+)/', $code, $match)) {
    $val = num_or_val($match[1]);
    $circuit[$to] = ~intval($val) & 0xFFFF;
  } elseif(preg_match('/(\w+) (AND|OR|LSHIFT|RSHIFT) (\w+)/', $code, $match)) {
    $from = num_or_val($match[1]);
    switch ($match[2]) {
      case 'AND':
        $circuit[$to] = $from & num_or_val($match[3]);
        break;
      case 'OR':
        $circuit[$to] = $from | num_or_val($match[3]);
        break;
      case 'LSHIFT':
        $circuit[$to] = $from << num_or_val($match[3]);
        break;
      case 'RSHIFT':
        $circuit[$to] = $from >> num_or_val($match[3]);
        break;
    }
  } else {
    die ('Invalid code '. $code);
  }
}

ksort($circuit);
var_dump($circuit);
