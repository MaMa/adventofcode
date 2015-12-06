<?php
$moves = str_split(file_get_contents('input/day03.txt'));
$world = [0=>[0=>1]];
$index = 0;
$santa = [
  0 => ['x' => 0, 'y' => 0]
];
$count = count($santa);

//move santa
foreach ($moves as $move) {
  $s = &$santa[$index++ % $count];
  $world[$s['x']][$s['y']]++;
  switch ($move) {
    case '>':
      $s['x']++;
      break;
    case '<':
      $s['x']--;
      break;
    case '^':
      $s['y']++;
      break;
    case 'v':
      $s['y']--;
      break;
  }
}

//count houses
$count = 0;
foreach($world as $rows) {
  foreach ($rows as $columns) $count++;
}

print ("Houses: ${count}\n");
