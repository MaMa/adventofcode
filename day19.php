<?php
ini_set('memory_limit','512M');
const TEST = false;
if (TEST) {
  $trans = [
    'H' => ['HO', 'OH'],
    'O' => ['HH'],
  ];
  $string = 'HOHOHO';
} else {
  $trans = [];
  $string = null;
  foreach(file('input/day19.txt') as $row) {
    $row = trim($row);
    if (preg_match('/(\w+) => (\w+)/', $row, $match)) {
      $trans[$match[1]][] = $match[2];
    } elseif(!empty($row)) {
      $string = $row;
    }
  }
}

function transform($trans, $string) {
  $results = [];
  $strLen = strlen($string);
  foreach ($trans as $key => $values) {
    $keyLen = strlen($key);
    for ($i=0; $i<=($strLen-$keyLen); $i++) {
      if (substr($string, $i, $keyLen) === $key) {
        $start = substr($string, 0, $i);
        $end = substr($string, $i+$keyLen);
        foreach($values as $replace) {
          $results[] = $start . $replace . $end;
        }
      }
    }
  }
  return array_unique($results);
}

//Part 1 solution
$part1 = transform($trans, $string);
print ("Uniques: ".count($part1) ."\n");

//reverse transformations
$reverse = [];
foreach($trans as $from => $values) {
  foreach ($values as $val) {
    if (isset($reverse[$val])) throw ('already exists');
    $reverse[$val][] = $from;
  }
}

$strings = [$string];
$found = false;
$count = 0;
do {
  $new = [];
  foreach($strings as $string) {
    $new = array_unique(array_merge($new, transform($reverse, $string)));
  }
  $strings = $new;
  $count++;
  printf("%d\t%d\n", $count, count($strings));
  foreach($strings as $str) {
    if ($str === 'e') $found = true;
  }
} while (!$found && $count < 10000);

print ("Count ${count}\n");
