<?php

$input = file('input/day07.txt');

$circuit = [];

function num_or_val($in) {
  global $circuit;
  if (is_numeric($in)) {
    return $in & 0xFFFF;
  } else {
    if (is_null($circuit[$in])) {
      throw new Exception('Not set '. $in);
    }
    return $circuit[$in];
  }
}

while($in = array_shift($input)) {
  if (!preg_match('/([\w ]+) -> (\w+)/', $in, $match)) continue;
  $code = $match[1];
  $to = $match[2];
  try {
    if (preg_match('/^(\w+)$/', $code, $match)) {
      if ($to == 'b') {
        $circuit[$to] = num_or_val('3176');
      } else {
        $circuit[$to] = num_or_val($match[1]);
      }
    }
    elseif (preg_match('/NOT (\w+)/', $code, $match)) {
      $circuit[$to] = ~num_or_val($match[1]);
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
      die ('Invalid input: '. $in);
    }
  } catch (Exception $e) {
    if (empty($circuit['a'])) $input[] = $in; //loop to end of input
  }
}

ksort($circuit);
//var_dump($circuit);

print("\nWire a: ". $circuit['a'] ."\n");
